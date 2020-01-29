<?php

namespace App\Http\Controllers;

class RecordsController extends Controller
{
    public function index(){

        return view('records');
    }

    public static function getLocationsPerRecordView($recordId){
        $locations = [];

        foreach(getLocationsPerRecord($recordId) as $location){
            $locations[] = $location->name;
        }

        return implode(', ', $locations);
    }
}
