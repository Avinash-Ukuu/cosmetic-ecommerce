<?php

namespace App\Http\Controllers\api;

use App\Models\Blog;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\ImageGallery;
use Illuminate\Http\Request;
use App\Models\MiddleSection;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data['banner']                 =       Banner::first();
        $data['products']               =       Product::with('productImages')->where('publish_type','publish')
                                                ->orderBy('product_created_at','desc')->take(5)->get();

        $data['glamifyBodyScrubs']      =       Category::with('products.productImages')->whereHas('products',function($query){
                                                    $query->take(4);
                                                })->where('slug','glamify-body-scrubs')->where('is_active',1)->get();

        $data['categories']             =       Category::with('products.productImages')->whereHas('products',function($query){
                                                    $query->take(6);
                                                })->where('is_active',1)->get();

        $data['blogs']                  =       Blog::where('publish_type','publish')->orderBy('created_at','desc')->take(3)->get();

        $data['middleSections']         =       MiddleSection::first();

        $data['imageGalleries']         =       ImageGallery::orderBy('created_at','desc')->get();

        $data['testimonials']           =       Testimonial::orderBy('created_at','desc')->get();

        return  response()->json($data,200);
    }
}
