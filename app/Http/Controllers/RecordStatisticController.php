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

        $productStorageMax = explode(';', $record->product['storage_t'])[1];
        $locationStorage = explode(';', $recordData[0]->location['storage_t']);

        $productStorageMaxSamples = RecordsData::where('temperature', '>', $productStorageMax)->count();

        $locationStorageMinSamples = RecordsData::where('temperature', '<', $locationStorage[0])->count();
        $locationStorageMaxSamples = RecordsData::where('temperature', '>', $locationStorage[1])->count();

        if($record->device_id == 3){

            $locationStorageMinSamples = 0;
            $locationStorageMaxSamples = 0;

            foreach($recordData as $rec) {
                $locationStorage = explode(';', $rec->location['storage_t']);
                if($rec->temperature > $locationStorage[0]) $locationStorageMinSamples++;
                if($rec->temperature > $locationStorage[1]) $locationStorageMaxSamples++;
            }
        }

        return array(
            'product_out_of_storage' => CarbonInterval::seconds( $productStorageMaxSamples * $interval )->cascade()->forHumans(),
            'location_out_of_storage_min' => CarbonInterval::seconds( $locationStorageMinSamples * $interval )->cascade()->forHumans(),
            'location_out_of_storage_max' => CarbonInterval::seconds( $locationStorageMaxSamples * $interval )->cascade()->forHumans()
        );

    }
}
