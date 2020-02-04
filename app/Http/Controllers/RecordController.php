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
        $slt_index = 1;

        foreach($recordData as $rec){

            $recordDataTimestamp[] = $rec->timestamp;
            $recordDataTemperature[] = $rec->temperature;
            $recordDataHumidity[] = $rec->humidity;
            $recordDataLight[] = $rec->light;

            $recordDataLimits[] = array((string) $rec->temperature, (string) $rec->humidity); // for comparing limits

            // izracun za model CISRO
            $k = pow(0.1 * round($rec->temperature) + 1, 2); // koeficient
            $t = round(floatval($record->intervals / 86400), 5) * $slt_index++; // v èasu t

            $slrCSIRO[] = round($slt - $k * $t, 2);

            // izracun za model SAL
            $t_sal = $this->getT_SALfromTable( round($rec->temperature) ); // t-sal za doloceno temperaturo
            $k_sal = round($slt / $t_sal, 2); // koeficient

            $slrSAL[] = round($slt - $k_sal * $t, 2);

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
        $prev_sl_range = [0, round($slt / 2), $slt, ($slt + 1)];


        $returnArray = [
            'record' => $record,
            'recordData' => $recordData,

            'recordDataTimestamp' => json_encode($recordDataTimestamp),
            'recordDataTemperature' => json_encode($recordDataTemperature),
            'recordDataHumidity' => json_encode($recordDataHumidity),
            'recordDataLight' => json_encode($recordDataLight),

            'recordDataStartDate' => $this->convertTimestampToArray($record->start_date),
            'prev_sl_range' => $prev_sl_range,

            'slrCSIRO_value' => end($slrCSIRO),
            'slrCSIRO_data' => json_encode($slrCSIRO),

            'slrSAL_value' => end($slrSAL),
            'slrSAL_data' => json_encode($slrSAL),

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

        $slt = intval($record->product['slt']) - $slDay;
        $slt_index = 1;

        foreach($recordData as $rec){

            // izracun za model CISRO
            $k = pow(0.1 * round($rec->temperature) + 1, 2); // koeficient
            $t = round(floatval($record->intervals / 86400), 5) * $slt_index++; // v èasu t

            $slrCSIRO[] = round($slt - $k * $t, 2);

            // izracun za model SAL
            $t_sal = $this->getT_SALfromTable( round($rec->temperature) ); // t-sal za doloceno temperaturo
            $k_sal = round($slt / $t_sal, 2); // koeficient

            $slrSAL[] = round($slt - $k_sal * $t, 2);
        }

        return response()->json([
            'status' => '200',

            'slrCSIRO_value' => end($slrCSIRO),
            'slrCSIRO_data' => $slrCSIRO,

            'slrSAL_value' => end($slrSAL),
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

    public function getPdfExport($id){
        $pdf = PDF::loadView('record', $this->getRecord($id));
        return $pdf->stream('pdfview.pdf');
    }
}
