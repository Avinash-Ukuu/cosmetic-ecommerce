<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('admin', new User());

        $data['brands']         =   Brand::orderBy("position")->get();

        return view('cms.brand.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('admin',new User());

        $data['object']         =       new Brand();
        $data['url']            =       route('brand.store');
        $data['method']         =       'POST';

        return view('cms.brand.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('admin',new User());
        $request->validate(['name'=>'required|string|max:255']);
        $allObjects             =       Brand::count();
        $brand                  =       new Brand();
        $brand->name            =       $request->name;
        $brand->slug            =       Str::slug($request->name);
        $brand->is_active       =       1;
        $brand->position        =       $allObjects  + 1;
        $brand->save();

        $data['message']        =   auth()->user()->name . " has created $brand->name";
        $data['action']         =   "created";
        $data['module']         =   "brand";
        $data['object']         =   $brand;
        saveLogs($data);

        Session::flash("success", "Brand Created");

        return redirect(route("brand.index"));
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
        $this->authorize('admin',new  User());

        $data['object']         =   Brand::find($id);
        if(empty($data['object']))
        {
            Session::flash("error","Data Not  Found");
            return back();
        }

        $data['url']            =   route("brand.update",['brand'=>$id]);
        $data['method']         =   "PUT";

        return view("cms.brand.form",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('admin',new User());
        $request->validate(['name'=>'required|string|max:255']);
        $brand               =       Brand::find($id);
        if(empty($brand))
        {
            Session::flash("error","Data not found");
            return redirect(route("brand.index"));
        }else if(empty(Str::slug($request->name)))
        {
            Session::flash("error","Name field should only contain alphabetical characters.");
            return back();
        }

        $brand->name            =       $request->name;
        $brand->slug            =       Str::slug($request->name);
        $brand->is_active       =       1;
        $brand->update();

        $data['message']        =       auth()->user()->name." has updated brand '$brand->name' to '$request->name' ";
        $data['action']         =       "updated";
        $data['module']         =       "brand";
        $data['object']         =       $brand;
        saveLogs($data);
        Session::flash("success","Brand Updated");

        return redirect(route("brand.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("superAdmin",auth()->user());
        $object                      =   Brand::find($id);
        if(empty($object))
        {
            Session::flash("error","Data not found");
            return back();
        }

        $data['message']             =   auth()->user()->name." has deleted '$object->name' brand";
        $data['action']              =   "deleted";
        $data['module']              =   "brand";
        $data['object']              =    $object;
        saveLogs($data);

        $object->delete();
        Session::flash("success","Brand Deleted");
        return redirect(route("brand.index"));
    }
}
