<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class SettingsController extends Controller
{
    public function index()
    {
        $this->middleware('auth');
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
}
