<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $object                 =       Banner::first();

        if(empty($object))
        {
            $data['object']     =       new Banner();
            $data['method']     =       'POST';
            $data['url']        =       route('banner.store');
        }else{
            $data['object']     =       Banner::find($object->id);
            $data['method']     =       'PUT';
            $data['url']        =       route('banner.update',['banner'=>$object->id]);
        }

        return view('cms.banner.form', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $banner                     =       new Banner();
        $banner->title              =       $request->title;
        $banner->description        =       $request->description;

        if ($request->has("image")) {
            $imageName  = "banner_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/banner/'), $imageName);
            $banner->image   =  $imageName;
        }
        $banner->save();

        $data['message']            =   auth()->user()->name . " has created '$banner->title' banner";
        $data['action']             =   "created";
        $data['module']             =   "banner";
        $data['object']             =   $banner;
        saveLogs($data);
        Session::flash("success", "Banner Created Successfully");

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner                     =       Banner::find($id);
        if(empty($banner))
        {
            Session::flash('Data not found');
            return back();
        }
        $banner->title              =       $request->title;
        $banner->description        =       $request->description;

        if ($request->has("image")) {
            if (file_exists("uploads/banner/" . $banner->image)) {
                File::delete("uploads/banner/" . $banner->image);
            }
            $imageName  = "banner_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/banner/'), $imageName);
            $banner->image   =  $imageName;
        }
        $banner->update();

        $data['message']            =   auth()->user()->name . " has updated '$banner->title' banner";
        $data['action']             =   "updated";
        $data['module']             =   "banner";
        $data['object']             =   $banner;
        saveLogs($data);
        Session::flash("success", "Banner Updated Successfully");

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
