<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use App\Device;
use App\Records;
use App\RecordsData;
use App\TemporaryData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ImportController extends Controller
{

    public function getImport(Request $request)
    {
        $request->user()->authorizeRoles(['editor', 'admin']);
        return view('import');
    }

    public function getHtmlForCsvHeaderData($csv_data){
        $html = "<table class='table' id='csvDataTable'>";

        if(empty($csv_data[0][0])) $csv_data[0] = array_fill(0, count($csv_data[1]), '-');

        // table header
        foreach($csv_data as $row){
            $html .= "<tr>";
            foreach($row as $key => $value){
                $html .= "<td>" . $value . "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "<tr>";
        // table body
        foreach($csv_data[0] as $key => $row){
            $row = strtolower($row);
            $html .= "<td>" . "<select name='fields-" . $key  .  "' class='form-control'>";
            if(!in_array($row, config('app.record_data'))) $row = '--ignore--';

            foreach(config('app.record_data') as $db_field){
                $selected = ($row == $db_field) ? 'selected' : '';
                $html .= "<option value='" . $db_field . "' " .$selected. ">" . $db_field . "</option>";
            }
            $html .= "</select>" . "</td>";
        }
        $html .= "</tr>" . "</table>";

        return $html;
    }

    public function removeWhiteString($data){
        $temp_data = [];
        foreach($data as $row){
            $lastEl = key(array_slice($row, -1, 1, true));
            $row[$lastEl] = explode(';;', $row[$lastEl])[0];
            $temp_data[] = $row;
        }
        return $temp_data;
    }

    public function getDeviceId($deviceName){
        return Device::where('name', $deviceName)->first()->id;
    }

    // M A I N  function for detect type of files
    public function parseImport(CsvImportRequest $request) {
        $record = new Records();
        $path = $request->file('csv_file')->getRealPath();
        $record->file_name = $request->file('csv_file')->getClientOriginalName();
        $ext = $request->file('csv_file')->getClientOriginalExtension();

        //$data = file($path, FILE_IGNORE_NEW_LINES);
        $data = array_map(function($v){return str_getcsv($v, "\t");}, file($path));
        //dump($data);

        // check if file is type TIDA
        if( $ext === 'csv' && substr( $data[0][0], 0, 1 ) === "#" ) {

            $data = array_map('str_getcsv', file($path));
            $record = $this->parseTIDAFiles($data, $record);
        }
        // check if file is type RHT10
        else if( substr( $data[0][0], 0, 2 ) === ">>" ){

            $record = $this->parseRHT10Files($data, $record);
        }
        // otherwise return response not supported file
        else{
            return response()->json([
                'status' => '500',
                'details' => 'File is not in proper format.'
            ])->setStatusCode(500);
        }

        // headers data
        $csv_data = array_slice($data, $record->nr_header_rows, 3);
        $headers_data = $this->getHtmlForCsvHeaderData($csv_data);

        //dump($csv_data);

        // save data to temporary table
        $temp_data = TemporaryData::create([
            'data' => json_encode($data)
        ]);

        // todo get file stats - samples, start times, interval, delay

        return response()->json(
            array(
                'headers_data' => $headers_data,
                'headers_nr_rows' => $record->nr_header_rows,
                'device' => $record->device_id,
                'temporary_table_id' => $temp_data->id,
                'samples' => $record->samples,
                'start_date' => $record->start_date,
                'end_date' => $record->end_date,
                'delay' => 0,
                'interval' => $record->intervals,
                'title' => $record->title,
                'file_name' => $record->file_name,
                'comment' => $record->comments
            )
        );
    }

    // S A V E
    // parsed data from font-end to database
    public function saveImport(Request $request){
        //dump($request->all());

        // check and prepare datetime format from different files
        if($request->input('device') === 'RHT10'){
            $start_date = Carbon::createFromFormat('m-d-Y H:i:s', $request->input('start_date'))->format('Y-m-d H:i:s');
            $end_date = Carbon::createFromFormat('m-d-Y H:i:s', $request->input('end_date'))->format('Y-m-d H:i:s');
        } else{
            $start_date = Carbon::parse($request->input('start_date'));
            $end_date = Carbon::parse($request->input('end_date'));
        }

        // save record in db
        $record = Records::create([
            'device_id' => $this->getDeviceId( $request->input('device') ),
            'product_id' => $request->input('product'),
            //'location_id' => $request->input('location'),
            'samples' => $request->input('samples'),
            'delay_time' => $request->input('delay'),
            'intervals' => $request->input('interval'),
            'slr' => 0,
            'limits' => '',
            'errors' => '',
            'alarms' => '',
            'title' => $request->input('title'),
            'comments' => $request->input('comment'),
            'user_id' => $request->input('user_id'), // todo change to read user-id from backend
            'start_date' => $start_date,
            'end_date' => $end_date,
            'file_name' => $request->input('file_name')
        ]);

        //get from database all data
        $csv_data = TemporaryData::find($request->input('temporary_table_id'));
        $temp_data = json_decode($csv_data->data, true);
        $headersData = $request->input('headers_data');

        foreach($temp_data as $nrRow => $row){

            // skip first static headers rows
            if($nrRow <= $request->input('headers_nr_rows')) continue;

            $recordData = new RecordsData();

            foreach($headersData as $nrCol => $column){
                $columnId = intval(explode("-", $column['id'])[1]);
                $columnValue = $column['value'];

                if($columnValue === '--ignore--') continue;

                $recordData[$column['value']] = $row[$columnId];
            };

            // prepare required timestamp fileds
            if(is_null($recordData->timestamp)){
                if($request->input('device') === 'RHT10') $recordData->date = Carbon::createFromFormat('m-d-Y', $recordData->date)->format('Y-m-d');
                $recordData->timestamp = Carbon::parse( $recordData->date . ' ' . $recordData->time );
            }

            // set location
            $recordData->location_id = $request->input('location');

            //save recordsData to database
            $recordData->records_id = $record->id;
            $recordData->save();

            //dump($recordData);
        };

        // TODO call RecordStatistic and update data


        return response()->json([
            'status' => '200',
            'details' => $record
        ]);
    }

    // G E N E R A T E   D A T A
    // input - generated input fileds
    // output - saved generated data in db and returned json response
    public function generateData(Request $request){
        //dump($request->all());

        // validate request
        $this->validate(request(),[
            'title-input'                   =>'required',
            'timestamp-input-gen-data'      =>'required|date',
            'interval-input-gen-data'       =>'required|numeric',
            'rec-gen-data_1'                =>'required|integer|min:1',
            'temp-gen-data_1'               =>'required|numeric',
            'hum-gen-data_1'                =>'required|numeric'
        ]);

        // intervals
        $interval = $request->input('interval-input-gen-data');
        // check and save datetime format
        $start_timestamp = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('timestamp-input-gen-data'));

        // save record in db
        $record = Records::create([
            'device_id' => $this->getDeviceId( 'Generated' ),
            'product_id' => $request->input('product-select-gen-data'),
            //'location_id' => 0, // because one-to-many relationsip
            'samples' => 0, // just for temporary time
            'delay_time' => 0,
            'intervals' => $interval,
            'slr' => 0,
            'limits' => '',
            'errors' => '',
            'alarms' => '',
            'title' => $request->input('title-input'),
            'comments' => $request->input('comment-input'),
            'user_id' => $request->input('user-id-gen-data'),
            'start_date' => $start_timestamp,
            'end_date' => $start_timestamp, // just for temporary time
            'file_name' => 'Generated file'
        ]);

        $calcTimestamp = $start_timestamp;
        $objRecordData = []; $rowNr = 0;

        // parsing generated records fileds in array
        foreach($request->all() as $fieldName => $fieldData){

            if(count(explode('_', $fieldName)) > 1) $rowNr = intval(explode('_', $fieldName)[1]);

            if(strpos($fieldName, "rec-gen-data") !== false){
                $objRecordData[$rowNr][0] = $fieldData;
            }
            if(strpos($fieldName, "temp-gen-data") !== false){
                $objRecordData[$rowNr][1] = $fieldData;
            }
            if(strpos($fieldName, "hum-gen-data") !== false){
                $objRecordData[$rowNr][2] = $fieldData;
            }
            if(strpos($fieldName, "location-select-gen-data") !== false){
                $objRecordData[$rowNr][3] = $fieldData;
            }
        }

        //dump($objRecordData);

        // for each records filed -> generating recordData and saving in db
        for($j = 1; $j <= $rowNr; $j++){

            for($i=0; $i < $objRecordData[$j][0]; $i++) {
                $recordData = new RecordsData();

                $recordData->temperature = $objRecordData[$j][1];
                $recordData->humidity = $objRecordData[$j][2];
                $recordData->location_id = $objRecordData[$j][3];

                $recordData->timestamp = $calcTimestamp;
                $recordData->date = $calcTimestamp->toDate();
                $recordData->time = Carbon::createFromFormat('H:i:s', explode(" ",$calcTimestamp)[1]);
                $calcTimestamp = $calcTimestamp->addSeconds($interval);

                //save recordsData to database
                $recordData->records_id = $record->id;
                $recordData->save();
            }
        }

        // update calculated record data
        $samples = RecordsData::where('records_id', $record->id)->count();
        $end_date = $calcTimestamp;

        Records::where('id', $record->id)->update(['samples' => $samples, 'end_date' => $end_date]);
        $record = Records::where('id', $record->id)->first();

        return response()->json([
            'status' => '200',
            'details' => $record
        ]);
    }

    // P A R S E   T I D A   files
    // input - data of file, object record
    // output - object record
    private function parseTIDAFiles($data, $record){
        $record->device_id = 'TIDA';

        //dump($data);

        // check if string ;; exist and remove this
        $lastEl = key(array_slice($data[0], -1, 1, true));
        if(array_key_exists(0, $data) && strpos($data[0][$lastEl], ';;') !== false){
            $data = $this->removeWhiteString($data);
        }

        // parse headers data
        foreach($data as $key => $row){
            if(array_key_exists(1, $row)){
                if($row[1] == 'Title') $record->title = $row[2];
                if($row[1] == 'Description') $record->comments = $row[2];
                if($row[1] == 'Location') $record->location_id = $row[2];
                if($row[1] == 'StartDate') $record->start_date = $row[2] . ' ' . $row[3];
                if($row[1] == 'EndDate') $record->end_date = $row[2] . ' ' . $row[3];
                if($row[1] == 'LogInterval(s)') $record->intervals = $row[2];
                if($row[1] == 'Measurements') $record->samples = $row[2];
            }
            if($row[0]  != '#' ){
                $record->nr_header_rows = $key;
                break;
            }
        }

        return $record;
    }

    // P A R S E   R H T 1 0   files
    // input - data of file, object record
    // output - object record
    private function parseRHT10Files($data, $record){
        $record->device_id = 'RHT10';
        $record->product_id = '';
        $record->location_id = '';
        $record->comments = '';

        // parse headers data
        foreach($data as $key => $row){
            $hdrDtrTemp = explode(">>", $row[0]);

            if(array_key_exists(1, $hdrDtrTemp)) $hdrDtr = explode(":", $hdrDtrTemp[1]);

            //dump($hdrDtr);

            if(array_key_exists(1, $hdrDtr)){
                if($hdrDtr[0] == 'Logging Name') $record->title = $hdrDtr[1];
                if($hdrDtr[0] == 'Sample Rate') $record->intervals = explode(' ', $hdrDtr[1])[0];
                if($hdrDtr[0] == 'Sample Points') $record->samples = $hdrDtr[1];
                if($hdrDtr[0] == 'FROM') {
                    $hdrDtrTime = explode("TO:", $hdrDtrTemp[1]);
                    $record->start_date = $hdrDtr[1] . ':' . $hdrDtr[2] . ':' . substr( $hdrDtr[3], 0, 2 );
                    $record->end_date = $hdrDtrTime[1];
                }
            }
            if(substr($row[0], 0, 3 ) === "---"){
                $record->nr_header_rows = $key + 1;
                break;
            }
        }

        return $record;
    }
}