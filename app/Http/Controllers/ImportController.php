<?php

namespace App\Http\Controllers;

use App\Device;
use App\Http\Requests\CsvImportRequest;
use App\Location;
use App\Product;
use App\Records;
use App\RecordsData;
use App\TemporaryData;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ImportController extends Controller
{

    public function getImport()
    {
        return view('import');
    }

    public function getHtmlForCsvHeaderData($csv_data){
        $html = "<table class='table' id='csvDataTable'>";
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

    public function getProducts($selected = null){
        return response()->json(
            Product::get(['id', 'name'])->toArray()
        );
    }

    public function getLocations($selected = null){
        return response()->json(
            Location::get(['id', 'name'])->toArray()
        );
    }

    public function parseImport(CsvImportRequest $request) {
        $path = $request->file('csv_file')->getRealPath();
        $file_name = $request->file('csv_file')->getClientOriginalName();
        $data = array_map('str_getcsv', file($path));

        dump($data);

        $nr_rows = 0; $title = ''; $description = ''; $location = '';
        $start_date = ''; $end_date = ''; $interval = 0; $samples = 0;

        // check if string ;; exist and remove this
        $lastEl = key(array_slice($data[0], -1, 1, true));
        if(array_key_exists(0, $data) && strpos($data[0][$lastEl], ';;') !== false){
            $data = $this->removeWhiteString($data);
        }

        // parse headers data
        foreach($data as $key => $row){
            if(array_key_exists(1, $row)){
                if($row[1] == 'Title') $title = $row[2];
                if($row[1] == 'Description') $description = $row[2];
                if($row[1] == 'Location') $location = $row[2];
                if($row[1] == 'StartDate') $start_date = $row[2] . ', ' . $row[3];
                if($row[1] == 'EndDate') $end_date = $row[2] . ', ' . $row[3];
                if($row[1] == 'LogInterval(s)') $interval = $row[2];
                if($row[1] == 'Measurements') $samples = $row[2];
            }
            if($row[0]  != '#' ){
                $nr_rows = $key;
                break;
            }
        }

        // headers data
        $csv_data = array_slice($data, $nr_rows, 3);
        $headers_data = $this->getHtmlForCsvHeaderData($csv_data);

        dump($csv_data[0]);

        // save data to temporary table
        $temp_data = TemporaryData::create([
            'data' => json_encode($data)
        ]);

        // todo get file stats - samples, start times, interval, delay

        return response()->json(
            array(
                'headers_data' => $headers_data,
                'product' => $this->getProducts(),
                'location' => $this->getLocations( $location ),
                'device' => 'TIDA',
                'temporary_table_id' => $temp_data->id,
                'samples' => $samples,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'delay' => 0,
                'interval' => $interval,
                'title' => $title,
                'file_name' => $file_name,
                'comment' => $description
            )
        );
    }

    public function saveImport(Request $request){
        //dump($request->all());

        // save record in db
        $record = Records::create([
            'device_id' => 1, // manual added ID of TIDA
            'product_id' => $request->input('product'),
            'location_id' => $request->input('location'),
            'samples' => $request->input('samples'),
            'delay_time' => $request->input('delay'),
            'intervals' => $request->input('interval'),
            'slr' => 0,
            'limits' => '',
            'errors' => '',
            'alarms' => '',
            'comments' => $request->input('comment'),
            'user_id' => $request->input('user_id'), // todo change to read user-id from backend
            'start_date' => Carbon::parse($request->input('start_date')),
            'end_date' => Carbon::parse($request->input('end_date')),
            'file_name' => $request->input('file_name')
        ]);

        //get from database all data
        $csv_data = TemporaryData::find($request->input('temporary_table_id'));
        $temp_data = json_decode($csv_data->data, true);
        $headersData = $request->input('headers_data');

        foreach($temp_data as $nrRow => $row){

            // skip first static headers rows
            if($row[0] === '#') continue;
            if(in_array($row[0], config('app.record_data'))) continue;

            $recordData = new RecordsData();

            foreach($headersData as $nrCol => $column){
                $columnId = intval(explode("-", $column['id'])[1]);
                $columnValue = $column['value'];

                if($columnValue === '--ignore--') continue;

                $recordData[$column['value']] = $row[$columnId];
            };

            // prepare required timestamp fileds
            if(is_null($recordData->timestamp)){
                $recordData->timestamp = Carbon::parse( $recordData->date . ' ' . $recordData->time );
            }

            //save recordsData to database
            $recordData->records_id = $record->id;
            $recordData->save();

            //dump($recordData);
        };

        return response()->json([
            'status' => '200',
            'details' => $record
        ]);
    }
}