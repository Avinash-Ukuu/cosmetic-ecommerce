<?php

namespace App\Http\Controllers\api;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        $blogs     =   Blog::where('publish_type','publish')->get();

        return  response()->json($blogs,200);
    }

    public function show(string $id)
    {
        $blog            =       Blog::where('publish_type','publish')->where('id', $id)->first();
        if(empty($blogs))
        {
            return  response()->json('Data not found',404);
        }
        $otherBlogs      =       Blog::where('publish_type','publish')->where('id','<>',$id)->orderBy('created_at', 'desc')->take(10)->get();

        return  response()->json(['blog'=>$blog,'otherBlogs'=>$otherBlogs],200);
    }
}
