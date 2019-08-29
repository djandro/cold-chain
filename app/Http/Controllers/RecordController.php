<?php

namespace App\Http\Controllers;

use App\Records;
use App\RecordsData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getRecord($id) {

        $record = Records::find( $id );
        $recordData =  RecordsData::where('records_id', $id)->get();

        $recordDataTimestamp = []; $recordDataTemperature = []; $recordDataHumidity = [];
        $recordDataDewPoints = []; $recordDataBatteryVoltage = [];

        foreach($recordData as $rec){
            $dt = Carbon::parse($rec->timestamp);

            $recordDataTimestamp[] = $rec->timestamp;
            $recordDataTemperature[] = array($dt->timestamp, $rec->temperature);
            $recordDataHumidity[] = array($dt->timestamp, $rec->humidity);
            $recordDataDewPoints[] = $rec->dew_points;
            $recordDataBatteryVoltage[] = $rec->battery_voltage;
        }

        return view('record', [
            'record' => $record,
            'recordData' => $recordData,
            'recordDataTimestamp' => json_encode($recordDataTimestamp),
            'recordDataTemperature' => json_encode($recordDataTemperature),
            'recordDataHumidity' => json_encode($recordDataHumidity),
            'recordDataDewPoints' => json_encode($recordDataDewPoints),
            'recordDataBatteryVoltage' => json_encode($recordDataBatteryVoltage)
        ]);
    }

}
