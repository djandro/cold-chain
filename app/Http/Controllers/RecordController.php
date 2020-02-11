<?php

namespace App\Http\Controllers;

use App\Records;
use App\RecordsData;
use PDF;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    public function index($id){

        return view('record', $this->getRecord($id));

    }

    public function getRecord($id) {

        $record = Records::find( $id );
        $recordData =  RecordsData::where('records_id', $id)->get();

        if($record == null or $recordData == null or $recordData == null or $recordData->count() == 0 or $record->count() == 0) return abort(404);

        $slt = intval($record->product['slt']);
        $slt_csiro = $slt; $slt_sal = $slt;

        foreach($recordData as $data){

            $recordDataTimestamp[] = $data->timestamp;
            $recordDataTemperature[] = $data->temperature;
            $recordDataHumidity[] = $data->humidity;
            $recordDataLight[] = $data->light;

            $recordDataLimits[] = array((string) $data->temperature, (string) $data->humidity); // for comparing limits

            // izraèun SL po CSIRO
            $slt_csiro = $this->getSl_CSIRO($slt_csiro, $record->intervals, $data->temperature);
            $slCSIRO[] = $slt_csiro;

            // izraèun SL po SAL
            $slt_sal = $this->getSl_SAL($slt_sal, $slt, $record->intervals, $data->temperature);
            $slSAL[] = $slt_sal;
        }

        // calculate time per location
        $locations = []; $locationsPerTime = [];

        foreach(getLocationsPerRecord($id) as $location){
            $locations[] = $location->name;

            $sec = CarbonInterval::seconds( intval($location->count) * intval($record->intervals) )->cascade()->forHumans();
            $locationsPerTime[] = array($location->name, $sec );
        }

        // calculating limits
        $max_t_value = max($recordDataTemperature); $min_t_value = min($recordDataTemperature);
        $max_h_value = max($recordDataHumidity); $min_h_value = min($recordDataHumidity);

        // dropdown vaules for shelf life previusly used
        $prev_sl_range = [0, 1, round($slt / 2), $slt];


        $returnArray = [
            'record' => $record,
            'recordData' => $recordData,

            'recordDataTimestamp' => json_encode($recordDataTimestamp),
            'recordDataTemperature' => json_encode($recordDataTemperature),
            'recordDataHumidity' => json_encode($recordDataHumidity),
            'recordDataLight' => json_encode($recordDataLight),

            'recordDataStartDate' => $this->convertTimestampToArray($record->start_date),
            'prev_sl_range' => $prev_sl_range,

            'slrCSIRO_value_css' => $this->getSlValueforHumans(end($slCSIRO))[0],
            'slrCSIRO_value' => $this->getSlValueforHumans(end($slCSIRO))[1],
            'slrCSIRO_data' => json_encode($slCSIRO),

            'slrSAL_value_css' => $this->getSlValueforHumans(end($slSAL))[0],
            'slrSAL_value' => $this->getSlValueforHumans(end($slSAL))[1],
            'slrSAL_data' => json_encode($slSAL),

            'locations' => implode(', ', $locations),
            'locationsPerTime' => $locationsPerTime,

            'alarms' => RecordStatisticController::getRecordStatistic($record),

            'recordLimits' => array(
                'max_t_value' => $max_t_value,
                'min_t_value' => $min_t_value,
                'max_h_value' => $max_h_value,
                'min_h_value' => $min_h_value,

                'max_t_count' => array_count_values(array_column($recordDataLimits, 0))[(string) $max_t_value],
                'min_t_count' => array_count_values(array_column($recordDataLimits, 0))[(string) $min_t_value],
                'max_h_count' => array_count_values(array_column($recordDataLimits, 1))[(string) $max_h_value],
                'min_h_count' => array_count_values(array_column($recordDataLimits, 1))[(string) $min_h_value]
            ),

        ];

        return $returnArray;
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'title' => 'required|max:125',
            'product_id' => 'required',
            'comments' => 'max:2000'
        ]);

        if ($validator->fails()) {
            return response()
                        ->json(['status' => '500'])
                        ->withErrors($validator)
                        ->withInput();
        }

        $id = $request->input('id');

        // save record in db
        Records::where('id', $id)->update([
            'title' => $request->input('title'),
            'product_id' => $request->input('product_id'),
            'comments' => $request->input('comments')
        ]);


        return response()->json([
            'status' => '200',
            'id' => $id
        ]);

        //return redirect()->route('record', ['id' => $id])->with('status', 'You successfully edit record with ID ' . $id . '.')->header('ResponseUri', 'records/'.$id);
    }

    public function destroy($id)
    {
        RecordsData::where('records_id', $id)->delete();
        Records::find($id)->delete($id);

        return response()->json([
            'status' => '200',
            'id' => $id
        ]);
    }

    public function updateShelfLifeData($recordId, $slDay){

        $record = Records::find( $recordId );
        $recordData =  RecordsData::where('records_id', $recordId)->get('temperature');

        if($record == null or $recordData == null){
            return response()->json([
                'status' => '500',
                'details' => 'Record or record data not exist.'
            ])->setStatusCode(500);
        }

        $slt = intval($record->product['slt']);
        $slt_csiro = $slt - $slDay;
        $slt_sal = $slt - $slDay;

        foreach($recordData as $rec){

            // izracun za model CISRO
            //$t = floatval($record->intervals) / 86400; // v èasu t
            //$k = pow(1 + round($rec->temperature) * 0.1, 2); // koeficient
            //$slt -= ($t * $k);

            $slt_csiro = $this->getSl_CSIRO($slt_csiro, $record->intervals, $rec->temperature);
            $slrCSIRO[] = $slt_csiro;

            // izracun za model SAL
            //$t_sal = $this->getT_SALfromTable( round($rec->temperature) ); // t-sal za doloceno temperaturo
            //$k_sal = ($slt / $t_sal); // koeficient

            $slt_sal = $this->getSl_SAL($slt_sal, $slt, $record->intervals, $rec->temperature);
            $slrSAL[] = $slt_sal;
        }

        return response()->json([
            'status' => '200',

            'slrCSIRO_value_css' => $this->getSlValueforHumans(end($slrCSIRO))[0],
            'slrCSIRO_value' => $this->getSlValueforHumans(end($slrCSIRO))[1],
            'slrCSIRO_data' => $slrCSIRO,

            'slrSAL_value_css' => $this->getSlValueforHumans(end($slrSAL))[0],
            'slrSAL_value' => $this->getSlValueforHumans(end($slrSAL))[1],
            'slrSAL_data' => $slrSAL
        ]);
    }

    public function convertTimestampToArray($timestamp){
        $recordDataStartDateTemp1 = explode(" ",$timestamp);
        $recordDataStartDate2 = array_merge(explode("-",$recordDataStartDateTemp1[0]), explode(":",$recordDataStartDateTemp1[1]));

        for ($i = 0; $i < count($recordDataStartDate2); $i++) {
            $recordDataStartDate[] = (int) $recordDataStartDate2[$i];
        }

        return $recordDataStartDate;
    }

    public function getT_SALfromTable($temperature){

        if($temperature > 30) $temperature = 30;
        if($temperature < 0) $temperature = 0;

        $t_sal = DB::table('sal_data')->where('temperature', $temperature)->first();

        return floatval($t_sal->sl);
    }

    // izracun za model CISRO
    public function getSl_CSIRO($slt, $interval, $temperature){

        $t = floatval($interval) / 86400; // v èasu t
        $k = pow(1 + round($temperature) * 0.1, 2); // koeficient
        return round($slt - $t * $k, 2); // preostala doba
    }

    // izracun za model SAL
    public function getSl_SAL($slt, $slt_ref, $interval, $temperature){

        $t = floatval($interval) / 86400; // v èasu t
        $t_sal = $this->getT_SALfromTable( round($temperature) ); // doba uporabnosti pri temperaturi T
        $k = intval($slt_ref / $t_sal); // koeficient iz referencne dobe uporabnosti deljeno z $t_sal
        return round($slt - $t * $k, 2); // preostala doba
    }

    // izpisi uporabniku prijazno preostalo dobo zivila
    public function getSlValueforHumans($value){
        $sl_temp = ( $value <= 0 ) ? '0.' : explode('.', $value);
        $sl_value = $sl_temp[0] .' days';
        $sl_value .= (!isset($sl_temp[1]) or $sl_temp[1] == 0) ? '' : ', ' . round($sl_temp[1] / 100 * 24) . ' hours';

        $sl_css_class = 'text-dark badge-warning';
        //$value = round($value);

        if($value <= 0) $sl_css_class = 'text-white badge-danger';
        else if($value >= 2) $sl_css_class = 'text-dark badge-success';

        return [$sl_css_class, $sl_value];
    }

    public function getPdfExport($id){
        $pdf = PDF::loadView('record', $this->getRecord($id));
        return $pdf->stream('pdfview.pdf');
    }
}
