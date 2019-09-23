<?php

namespace App\Http\Controllers;

use App\Device;
use App\Location;
use App\Product;
use App\Records;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        return view('records', [
            'records' => $this->getRecords(),
            'products' => $this->getProducts(),
            'locations' => $this->getLocations(),
            'devices' => $this->getDevices()
        ]);
    }

    public function getProducts(){
        $products = Product::orderBy('id', 'desc')->get(['id', 'name']);
        return $products;
    }

    public function getLocations(){
        $locations = Location::orderBy('id', 'desc')->get(['id', 'name']);
        return $locations;
    }

    public function getDevices(){
        $devices = Device::get(['id', 'name']);
        return $devices;
    }

    public function getRecords() {
        $records = Records::orderBy('id', 'desc')->paginate(10);
        return $records;
    }
}
