<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products     =   Product::with('productImages','category','brand')->where('publish_type','publish')->orderBy('product_created_at','desc')->get();

        return  response()->json($products,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product            =       Product::with('productImages','category','brand','reviews')->where('publish_type','publish')->where('id', $id)->first();
        if(empty($product))
        {
            return  response()->json('Data not found',404);
        }
        $otherProducts      =       Product::with('productImages','brand')->where('publish_type','publish')->where('id','<>',$id)->orderBy('product_created_at', 'desc')->take(10)->get();

        return  response()->json(['product'=>$product,'otherProducts'=>$otherProducts],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
