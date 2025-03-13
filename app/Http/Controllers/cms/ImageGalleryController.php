<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use App\Models\ImageGallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ImageGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['imageGalleries']       =   ImageGallery::orderBy('created_at','desc')->get();

        return view('cms.imageGallery.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['object']         =       new ImageGallery();
        $data['method']         =       'POST';
        $data['url']            =       route('image-gallery.store');

        return view('cms.imageGallery.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
        ]);

        $imageGallery                     =       new ImageGallery();
        $imageGallery->name               =       $request->name;

        if ($request->has("image")) {
            $imageName  = "imageGallery_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/imageGallery/'), $imageName);
            $imageGallery->image   =  $imageName;
        }
        $imageGallery->save();

        $data['message']            =   auth()->user()->name . " has created '$imageGallery->name' imageGallery";
        $data['action']             =   "created";
        $data['module']             =   "imageGallery";
        $data['object']             =   $imageGallery;
        saveLogs($data);
        Session::flash("success", "Image Gallery Created Successfully");

        return redirect(route('image-gallery.index'));
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
        $data['object']         =       ImageGallery::find($id);

        if(empty($data))
        {
            Session::flash("error","Data Not Found");
            return back();
        }

        $data['method']         =       'PUT';
        $data['url']            =       route('image-gallery.update',['image_gallery'=>$id]);

        return view('cms.imageGallery.form',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'             => 'required|string|max:255'
        ]);

        $imageGallery                   =       ImageGallery::find($id);
        if(empty($imageGallery))
        {
            Session::flash("success",'Data not found');
            return back();
        }
        $imageGallery->name             =       $request->name;
        if ($request->has("image")) {
            if (file_exists("uploads/imageGallery/" . $imageGallery->image)) {
                File::delete("uploads/imageGallery/" . $imageGallery->image);
            }
            $imageName  = "imageGallery_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/imageGallery/'), $imageName);
            $imageGallery->image   =  $imageName;
        }
        $imageGallery->update();

        $data['message']            =   auth()->user()->name . " has updated '$imageGallery->name' imageGallery";
        $data['action']             =   "updated";
        $data['module']             =   "imageGallery";
        $data['object']             =   $imageGallery;
        saveLogs($data);
        Session::flash("success", "Data Updated Successfully");

        return redirect(route('image-gallery.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imageGallery   =   ImageGallery::find($id);
        if (empty($imageGallery)) {
            Session::flash("error", "Data not found");
            return back();
        }

        if (file_exists("uploads/imageGallery/" . $imageGallery->image)) {
            File::delete("uploads/imageGallery/" . $imageGallery->image);
        }

        $data['message']        =   auth()->user()->name . " has deleted '$imageGallery->name' imageGallery";
        $data['action']         =   "deleted";
        $data['module']         =   "imageGallery";
        $data['object']         =   $imageGallery;
        saveLogs($data);
        $imageGallery->delete();
        Session::flash("success", "Data Deleted");
        return redirect(route("image-gallery.index"));
    }
}
