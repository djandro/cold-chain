<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $locations = Location::orderBy('id', 'desc')->get();

        return Response::json( $locations );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //dump($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:125',
            't_alert_min' => 'required|numeric',
            't_alert_max' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect('settings')
            ->withErrors($validator)
            ->withInput();
        }

        // save record in db
        $location = Location::updateOrCreate([
            'id' => $request->input('id')
        ],[
            'name' => $request->input('name'),
            'storage_t' => $request->input('t_alert_min') . ';' . $request->input('t_alert_max'),
            'description' => $request->input('description'),
            'color' => $request->input('color')
        ]);

        return response()->json([
            'status' => '200',
            'details' => $location
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $location = Location::find($id);
        return view('location.show', array('location' => $location));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $location = Location::where($where)->first();

        return response()->json([
            'status' => '200',
            'details' => $location
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Location::find($id)->delete($id);

        return response()->json([
            'status' => '200',
            'id' => $id
        ]);
    }
}
