<?php

namespace App\Http\Controllers\api;

use App\Models\Blog;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data['bannerProduct']          =       Product::with('productImages')->where('publish_type','publish')->orderBy('product_created_at','desc')->first();
        $data['otherProducts']          =       Product::with('productImages')->where('id','<>', $data['bannerProduct']->id)->where('publish_type','publish')
                                                ->orderBy('product_created_at','desc')->take(8)->get();

        $data['parentCategories']       =       Category::whereNull('parent_id')->get();
        $data['blogs']                  =       Blog::where('publish_type','publish')->orderBy('created_at','desc')->take(4)->get();

        return  response()->json($data,200);
    }
}
