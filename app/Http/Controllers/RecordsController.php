<?php

namespace App\Http\Controllers;

class RecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        return view('records');
    }
}
