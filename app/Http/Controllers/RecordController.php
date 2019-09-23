<?php

namespace App\Http\Controllers;

use App\Records;
use App\RecordsData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecordController extends Controller
{
    
    public function getRecord($id) {

        $record = Records::find( $id );
        $recordData =  RecordsData::where('records_id', $id)->get();

        foreach($recordData as $rec){
            $dt = Carbon::parse($rec->timestamp);

            $recordDataTimestamp[] = $rec->timestamp;
            $recordDataTemperature[] = array($dt->timestamp, $rec->temperature);
            $recordDataHumidity[] = array($dt->timestamp, $rec->humidity);
            $recordDataLight[] = $rec->light;

            $recordDataLimits[] = array((string) $rec->temperature, (string) $rec->humidity); // for comparing limits

            //$recordDataDewPoints[] = $rec->dew_points; --> zaenkrat ne izpisujemo
            //$recordDataBatteryVoltage[] = $rec->battery_voltage; -> zaenkrat ne izpisujemo
        }

        // calculating limits
        $temperatureColumn = array_column($recordDataTemperature, 1);
        $humidityColumn = array_column($recordDataHumidity, 1);

        $max_t_value = max($temperatureColumn); $min_t_value = min($temperatureColumn);
        $max_h_value = max($humidityColumn); $min_h_value = min($humidityColumn);

        return view('record', [
            'record' => $record,
            'recordData' => $recordData,

            'recordDataTimestamp' => json_encode($recordDataTimestamp),
            'recordDataTemperature' => json_encode($recordDataTemperature),
            'recordDataHumidity' => json_encode($recordDataHumidity),
            'recordDataLight' => json_encode($recordDataLight),

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
