<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::orderBy('name', 'desc')->get();
        return Response::json($products);
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
            'slt' => 'required|numeric',
            'storage_t_min' => 'required|numeric',
            'storage_t_max' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect('settings')
            ->withErrors($validator)
            ->withInput();
        }

        // save record in db
        $product = Product::updateOrCreate([
            'id' => $request->input('id')
        ],[
            'name' => $request->input('name'),
            'slt' => $request->input('slt'),
            'storage_t' => $request->input('storage_t_min') . ";" . $request->input('storage_t_max'),
            'description' => $request->input('description')
        ]);

        return response()->json([
            'status' => '200',
            'details' => $product
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
        $product = Product::find($id);
        return view('product.show', array('product' => $product));
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
        $product  = Product::where($where)->first();

        return response()->json([
            'status' => '200',
            'details' => $product
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
        Product::find($id)->delete($id);

        return response()->json([
            'status' => '200',
            'id' => $id
        ]);
    }
}
