<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $categories     =   Category::where('is_active',1)->get();

        return  response()->json($categories,200);
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
        $category       =       Category::with('products.productImages')->where('is_active',1)->where('id', $id)->first();

        if(empty($category))
        {
            return  response()->json('Data not found',404);
        }

        return  response()->json($category,200);
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
