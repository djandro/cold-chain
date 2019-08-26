<?php

namespace App\Http\Controllers;

use App\Records;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    public function getRecords()
    {
        $records = Records::paginate(10);

        return view('records', [
            'records' => $records
        ]);
    }
}
