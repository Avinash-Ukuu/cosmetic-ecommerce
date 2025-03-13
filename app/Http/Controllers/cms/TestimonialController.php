<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['testimonials']       =   Testimonial::orderBy('created_at','desc')->get();

        return view('cms.testimonial.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['object']         =       new Testimonial();
        $data['method']         =       'POST';
        $data['url']            =       route('testimonial.store');

        return view('cms.testimonial.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'message' => 'required|string',
        ]);

        $testimonial                     =       new Testimonial();
        $testimonial->name               =       $request->name;
        $testimonial->message            =       $request->message;

        if ($request->has("image")) {
            $imageName  = "testimonial_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/testimonial/'), $imageName);
            $testimonial->image   =  $imageName;
        }
        $testimonial->save();

        $data['message']            =   auth()->user()->name . " has created '$testimonial->name' testimonial";
        $data['action']             =   "created";
        $data['module']             =   "testimonial";
        $data['object']             =   $testimonial;
        saveLogs($data);
        Session::flash("success", "Testimonial Created Successfully");

        return redirect(route('testimonial.index'));
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
        $data['object']         =       Testimonial::find($id);
        if(empty($data))
        {
            Session::flash('error','Data Not Found');

            return back();
        }
        $data['method']         =       'PUT';
        $data['url']            =       route('testimonial.update',['testimonial'=>$id]);

        return view('cms.testimonial.form',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'message' => 'required|string',
        ]);

        $testimonial                   =       Testimonial::find($id);
        if(empty($testimonial))
        {
            Session::flash("success",'Data not found');
            return back();
        }
        $testimonial->name               =       $request->name;
        $testimonial->message            =       $request->message;
        if ($request->has("image")) {
            if (file_exists("uploads/testimonial/" . $testimonial->image)) {
                File::delete("uploads/testimonial/" . $testimonial->image);
            }
            $imageName  = "testimonial_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/testimonial/'), $imageName);
            $testimonial->image   =  $imageName;
        }
        $testimonial->update();

        $data['message']            =   auth()->user()->name . " has updated '$testimonial->name' testimonial";
        $data['action']             =   "updated";
        $data['module']             =   "testimonial";
        $data['object']             =   $testimonial;
        saveLogs($data);
        Session::flash("success", "Data Updated Successfully");

        return redirect(route('testimonial.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonial   =   Testimonial::find($id);
        if (empty($testimonial)) {
            Session::flash("error", "Data not found");
            return back();
        }

        if (file_exists("uploads/testimonial/" . $testimonial->image)) {
            File::delete("uploads/testimonial/" . $testimonial->image);
        }

        $data['message']        =   auth()->user()->name . " has deleted '$testimonial->name' testimonial";
        $data['action']         =   "deleted";
        $data['module']         =   "testimonial";
        $data['object']         =   $testimonial;
        saveLogs($data);
        $testimonial->delete();
        Session::flash("success", "Data Deleted");
        return redirect(route("testimonial.index"));
    }
}
