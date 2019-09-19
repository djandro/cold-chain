<?php

namespace App\Http\Controllers;

use App\Device;
use App\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['manager', 'admin']);
        return view('settings');
    }

    public function getUsers()
    {
        $users = User::orderBy('id', 'desc')->get();

        foreach($users as $key => $user){
             $user->setAttribute('roles', $user->getRoles()->toArray());
        }

        return Response::json( $users );
    }

    public function getDevices(){
        $devices = Device::orderBy('id', 'asc')->get();
        return Response::json( $devices );
    }
}
