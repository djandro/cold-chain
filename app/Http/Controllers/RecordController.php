<?php

namespace App\Http\Controllers;

use App\Records;
use Illuminate\Http\Request;

class RecordController extends Controller
{

    public function getRecord($id) {

        $record = Records::find( $id );

        return view('record', [
            'record' => $record
        ]);
    }

}
