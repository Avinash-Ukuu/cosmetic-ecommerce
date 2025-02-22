<?php

namespace App\Http\Controllers\api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'comment'    => 'required|string',
            'rating'     => 'required|integer|min:1|max:5',
        ]);

        $review         =   Review::create([
                                'product_id' => $request->product_id,
                                'user_id'    => $request->user_id, 
                                'comment'    => $request->comment,
                                'rating'     => $request->rating,
                            ]);

        return response()->json([
            'message' => 'Review submitted successfully',
            'review'  => $review
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
