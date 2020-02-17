<?php

namespace App\Http\Controllers;

use App\Device;
use App\Location;
use App\Product;
use App\Records;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('approved')->except('approval');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $viewer = $request->user()->hasRole('viewer');
        if($viewer) return redirect('records');

        $request->user()->authorizeRoles(['editor', 'admin']);


        return View::make('home', [
            'records_count' => $this->getRecordsCount(),
            'products_count' => $this->getProductsCount(),
            'locations_count' => $this->getLocationsCount(),
            'devices_count' => $this->getDevicesCount(),
            'users_count' => $this->getUsersCount(),
            'users_for_approve' => $this->getUsersForApprove()
        ]);
    }

    public function approval()
    {
        return view('auth/approval');
    }

    public function getProductsCount(){
        $products = Product::count();
        return $products;
    }

    public function getLocationsCount(){
        $locations = Location::count();
        return $locations;
    }

    public function getDevicesCount(){
        $devices = Device::count();
        return $devices;
    }

    public function getRecordsCount() {
        $records = Records::where('status', '=', 1)->count();
        return $records;
    }

    public function getUsersCount(){
        $users = User::All()->count();
        return $users;
    }

    public function getUsersForApprove(){
        $users = User::whereNull('approved_at')->count();
        return $users;
    }

    /*
    public function someAdminStuff(Request $request)
    {
      $request->user()->authorizeRoles('manager');
      return view(‘some.view’);
    }
    */

}
