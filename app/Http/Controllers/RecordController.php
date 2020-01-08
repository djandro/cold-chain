<?php

namespace App\Http\Controllers;

use App\Records;
use App\RecordsData;
use Carbon\CarbonInterval;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{

    public function convertTimestampToArray($timestamp){
        $recordDataStartDateTemp1 = explode(" ",$timestamp);
        $recordDataStartDate2 = array_merge(explode("-",$recordDataStartDateTemp1[0]), explode(":",$recordDataStartDateTemp1[1]));

        for ($i = 0; $i < count($recordDataStartDate2); $i++) {
            $recordDataStartDate[] = (int) $recordDataStartDate2[$i];
        }

        return $recordDataStartDate;
    }
    
    public function getRecord($id) {

        $record = Records::find( $id );
        $recordData =  RecordsData::where('records_id', $id)->get();

        $slt = intval($record->product['slt']);
        $slt_index = 1;

        foreach($recordData as $rec){
            $dt = Carbon::parse($rec->timestamp);

            $recordDataTimestamp[] = $rec->timestamp;
            $recordDataTemperature[] = $rec->temperature;
            $recordDataHumidity[] = $rec->humidity;
            $recordDataLight[] = $rec->light;

            $recordDataLimits[] = array((string) $rec->temperature, (string) $rec->humidity); // for comparing limits

            // izracun za model CISRO
            $k = pow(0.1 * round($rec->temperature) + 1, 2); // koeficient
            $t = round(floatval($record->intervals / 86400), 5) * $slt_index++; // v èasu t

            $recordDataSL[] = round($slt - $k * $t, 2);


            //$recordDataDewPoints[] = $rec->dew_points; --> zaenkrat ne izpisujemo
            //$recordDataBatteryVoltage[] = $rec->battery_voltage; -> zaenkrat ne izpisujemo
        }

        // calculate time per location
        $locationsArray = DB::table('records_data')
                            ->join('locations', 'records_data.location_id', '=', 'locations.id')
                            ->select('locations.name as name', DB::raw('COUNT(location_id) as count'))
                            ->where('records_id', $id)
                            ->groupBy('locations.name')
                            ->get();

        foreach($locationsArray as $location){
            $locations[] = $location->name;

            $sec = CarbonInterval::seconds( intval($location->count) * intval($record->intervals) )->cascade()->forHumans();
            $locationsPerTime[] = array($location->name, $sec );
        }

        // calculating limits
        $max_t_value = max($recordDataTemperature); $min_t_value = min($recordDataTemperature);
        $max_h_value = max($recordDataHumidity); $min_h_value = min($recordDataHumidity);

        return view('record', [
            'record' => $record,
            'recordData' => $recordData,

            'recordDataTimestamp' => json_encode($recordDataTimestamp),
            'recordDataTemperature' => json_encode($recordDataTemperature),
            'recordDataHumidity' => json_encode($recordDataHumidity),
            'recordDataLight' => json_encode($recordDataLight),

            'recordDataSL' => json_encode($recordDataSL),
            'recordDataStartDate' => $this->convertTimestampToArray($record->start_date),

            'locations' => implode(', ', $locations),
            'locationsPerTime' => $locationsPerTime,

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

        ]);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $record = Records::where($where)->first();

        return response()->json([
            'status' => '200',
            'details' => $record
        ]);
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

}
