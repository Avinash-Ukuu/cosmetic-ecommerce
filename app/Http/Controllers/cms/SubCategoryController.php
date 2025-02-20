<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\SubCategoryRequest;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view',new Category());

        $data['subCategories']         =   SubCategory::with('category')->get();

        return view('cms.subCategory.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',new Category());
        $data['object']         =       new SubCategory();
        $data['url']            =       route('sub-category.store');
        $data['method']         =       'POST';
        $data['categories']     =       Category::where('is_active','1')->pluck('name','id')->toArray();

        return view('cms.subCategory.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {
        $this->authorize('create',new Category());
        $duplicateSubCategory                =   SubCategory::where(['category_id'=>$request->category_id,'name'=>strtolower($request->name)])->exists();
        if($duplicateSubCategory){return back()->with("error","Sub Category already exists");}
        $subCategory                =       new SubCategory();
        $subCategory->category_id   =       $request->category_id;
        $subCategory->name          =       $request->name;
        $subCategory->slug          =       Str::slug($request->name);
        $subCategory->is_active     =       1;
        $subCategory->save();

        $data['message']            =   auth()->user()->name . " has created $subCategory->name";
        $data['action']             =   "created";
        $data['module']             =   "sub category";
        $data['object']             =   $subCategory;
        saveLogs($data);

        Session::flash("success", "Sub Category Created");

        return redirect(route("sub-category.index"));
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
        $this->authorize('create',new Category());
        $data['object']         =       SubCategory::with('category')->find($id);
        if(empty($data['object']))
        {
            Session::flash('error','Data not found');

            return redirect(route('sub-category.index'));
        }
        $data['url']            =       route('sub-category.update',['sub_category'=>$id]);
        $data['method']         =       'PUT';
        $data['categories']     =       Category::where('is_active','1')->pluck('name','id')->toArray();

        return view('cms.subCategory.form',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, string $id)
    {
        $this->authorize('create',new Category());
        $duplicateSubCategory                =   SubCategory::where("id","<>",$id)->
        where(['category_id'=>$request->category_id,'name'=>strtolower($request->name)])->exists();
        if($duplicateSubCategory){return back()->with("error","Sub Category already exists");}

        $subCategory                =       SubCategory::with('category')->find($id);
        if(empty($subCategory))
        {
            Session::flash('error','Data not found');

            return back();
        }

        $subCategory->name          =       $request->name;
        $subCategory->slug          =       Str::slug($request->name);
        $subCategory->update();

        $data['message']            =   auth()->user()->name . " has updated $subCategory->name";
        $data['action']             =   "updated";
        $data['module']             =   "sub category";
        $data['object']             =   $subCategory;
        saveLogs($data);

        Session::flash("success", "Sub Category Updated");

        return redirect(route("sub-category.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("superAdmin",auth()->user());
        $object                      =   SubCategory::find($id);
        if(empty($object))
        {
            Session::flash("error","Data not found");
            return back();
        }

        $data['message']             =   auth()->user()->name." has deleted '$object->name' sub category";
        $data['action']              =   "deleted";
        $data['module']              =   "sub category";
        $data['object']              =    $object;
        saveLogs($data);

        $object->delete();
        Session::flash("success","Sub Category Deleted");
        return redirect(route("sub-category.index"));
    }
}
