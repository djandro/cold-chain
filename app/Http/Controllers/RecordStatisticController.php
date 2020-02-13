<?php

namespace App\Http\Controllers;

use App\Records;
use App\RecordsData;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class RecordStatisticController extends Controller
{

    public function getRecordOutOfStorageTime(){
        //todo from getRecordStatistic
    }

    public function getRecordErrors(){
        //todo calculate samples, start/end date, interval is correct from all RecordsData
    }

    public static function getRecordStatistic(Records $record){

        $recordData = RecordsData::where('records_id', $record->id)->get();
        $interval = intval($record->intervals);

        $productStorage = explode(';', $record->product['storage_t']);
        $locationStorage = explode(';', $recordData[0]->location['storage_t']);

        // isset for examples of record that do not have product
        if( !isset($productStorage[1]) ) {
            $productStorageMinSamples = 0;
            $productStorageMaxSamples = 0;
        } else {
            $productStorageMinSamples = RecordsData::where('temperature', '<', $productStorage[0])->where('records_id', '=', $record->id)->count();
            $productStorageMaxSamples = RecordsData::where('temperature', '>', $productStorage[1])->where('records_id', '=', $record->id)->count();
        }

        // isset for examples of record that do not have location
        if( !isset($locationStorage[1]) ){
            $locationStorageMinSamples = 0;
            $locationStorageMaxSamples = 0;
        }
        else{
            $locationStorageMinSamples = RecordsData::where('temperature', '<', $locationStorage[0])->where('records_id', '=', $record->id)->count();
            $locationStorageMaxSamples = RecordsData::where('temperature', '>', $locationStorage[1])->where('records_id', '=', $record->id)->count();
        }

        if($record->device_id == 3){

            $locationStorageMinSamples = 0;
            $locationStorageMaxSamples = 0;

            foreach($recordData as $rec) {
                $locationStorage = explode(';', $rec->location['storage_t']);
                if($rec->temperature > $locationStorage[0]) $locationStorageMinSamples++;
                if($rec->temperature > $locationStorage[1]) $locationStorageMaxSamples++;
            }
        }

        $failedHumidityMin = RecordsData::where('humidity', '<', 0)->where('records_id', '=', $record->id)->count();
        $failedHumidityMax = RecordsData::where('humidity', '>', 100)->where('records_id', '=', $record->id)->count();

        return array(
            'product_out_of_storage_samples' => ($productStorageMaxSamples + $productStorageMinSamples),
            'product_out_of_storage_time' => CarbonInterval::seconds( ($productStorageMaxSamples + $productStorageMinSamples) * $interval )->cascade()->forHumans(),
            'location_out_of_storage_samples' => ($locationStorageMaxSamples + $locationStorageMinSamples),
            'location_out_of_storage_time' => CarbonInterval::seconds( ($locationStorageMaxSamples + $locationStorageMinSamples) * $interval )->cascade()->forHumans(),
            'failed_humidity_samples' => ($failedHumidityMin + $failedHumidityMax)
        );

    }
}
