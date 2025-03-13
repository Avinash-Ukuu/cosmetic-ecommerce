<?php

namespace App\Http\Controllers\api;

use App\Models\ImageGallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageGalleryController extends Controller
{
    public function index()
    {
        $imageGalleries     =   ImageGallery::orderBy('created_at','desc')->get();

        return  response()->json($imageGalleries,200);
    }
}
