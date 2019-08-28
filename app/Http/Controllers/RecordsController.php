<?php

namespace App\Http\Controllers;

use App\Records;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getRecords()
    {
        $records = Records::orderBy('id', 'desc')->paginate(10);

        return view('records', [
            'records' => $records
        ]);
    }
}
