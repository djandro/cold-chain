<?php

namespace App\Http\Controllers;

use App\Device;
use App\Notifications\NotyAprovedUser;
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
        $request->user()->authorizeRoles(['editor', 'admin']);
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

    public function approveUser(Request $request, $user_id)
    {
        $request->user()->authorizeRoles(['admin']);

        $user = User::findOrFail($user_id);
        $user->update(['approved_at' => now()]);

        if ($user) {
            $user->notify(new NotyAprovedUser());
        }

        return redirect()->route('settings')->with('status', 'User ' . $user->name . ' approved successfully!');
    }

    public function getDevices()
    {
        $devices = Device::orderBy('id', 'asc')->get();
        return Response::json( $devices );
    }
}
