<?php

namespace App\Http\Controllers\api;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands     =   Brand::with('products')->where('is_active',1)->get();

        return  response()->json($brands,200);
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
        $brand       =       Brand::with('products')->where('is_active',1)->where('id', $id)->first();

        if(empty($brand))
        {
            return  response()->json('Data not found',404);
        }

        return  response()->json($brand,200);
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
