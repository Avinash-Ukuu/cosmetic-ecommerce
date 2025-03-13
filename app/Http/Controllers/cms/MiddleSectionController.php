<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MiddleSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class MiddleSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $object                 =       MiddleSection::first();

        if(empty($object))
        {
            $data['object']     =       new MiddleSection();
            $data['method']     =       'POST';
            $data['url']        =       route('middle-section.store');
        }else{
            $data['object']     =       MiddleSection::find($object->id);
            $data['method']     =       'PUT';
            $data['url']        =       route('middle-section.update',['middle_section'=>$object->id]);
        }

        return view('cms.middleSection.form', $data);
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
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required'
        ]);

        $middleSection                     =       new MiddleSection();
        $middleSection->title              =       $request->title;
        $middleSection->description        =       $request->description;

        if ($request->has("image")) {
            $imageName  = "middleSection_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/middleSection/'), $imageName);
            $middleSection->image   =  $imageName;
        }
        $middleSection->save();

        $data['message']            =   auth()->user()->name . " has created '$middleSection->title' middleSection";
        $data['action']             =   "created";
        $data['module']             =   "middleSection";
        $data['object']             =   $middleSection;
        saveLogs($data);
        Session::flash("success", "Middle Section Created Successfully");

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
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required'
        ]);

        $middleSection                     =       MiddleSection::find($id);
        if(empty($middleSection))
        {
            Session::flash("error",'Data not found');
            return back();
        }
        $middleSection->title              =       $request->title;
        $middleSection->description        =       $request->description;

        if ($request->has("image")) {
            if (file_exists("uploads/middleSection/" . $middleSection->image)) {
                File::delete("uploads/middleSection/" . $middleSection->image);
            }
            $imageName  = "middleSection_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/middleSection/'), $imageName);
            $middleSection->image   =  $imageName;
        }
        $middleSection->update();

        $data['message']            =   auth()->user()->name . " has updated '$middleSection->title' middleSection";
        $data['action']             =   "updated";
        $data['module']             =   "middleSection";
        $data['object']             =   $middleSection;
        saveLogs($data);
        Session::flash("success", "Data Updated Successfully");

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
