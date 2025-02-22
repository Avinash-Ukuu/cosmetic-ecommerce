<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view',new Category());

        $data['categories']             =   Category::orderBy('created_at','desc')->get();

        return view('cms.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category                   =       new Category();
        $this->authorize('create',$category);
        $data['object']             =       $category;
        $data['url']                =       route('category.store');
        $data['method']             =       'POST';

        return view('cms.category.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category               =       new Category();
        $this->authorize('create',$category);
        $category->name         =       $request->name;
        $category->slug         =       Str::slug($request->name);
        $category->is_active    =       1;

        if ($request->has("image")) {
            $imageName  = "category_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/categories/'), $imageName);
            $category->image    =  $imageName;
        }

        $category->save();

        $data['message']        =   auth()->user()->name . " has created $category->name";
        $data['action']         =   "created";
        $data['module']         =   "category";
        $data['object']         =   $category;
        saveLogs($data);

        Session::flash("success", "Category Created");

        return redirect(route("category.index"));
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
        $category                   =       new Category();
        $this->authorize('update',$category);
        $data['object']             =   $category->find($id);
        if(empty($data['object']))
        {
            Session::flash("error","Data Not Found");
            return back();
        }

        $data['url']                =   route("category.update",['category'=>$id]);
        $data['method']             =   "PUT";

        return view("cms.category.form",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $this->authorize('update',new Category());
        $category               =       Category::find($id);
        if(empty($category))
        {
            Session::flash("error","Data not found");
            return redirect(route("category.index"));
        }else if(empty(Str::slug($request->name)))
        {
            Session::flash("error","Name field should only contain alphabetical characters.");
            return back();
        }

        $category->name         =       $request->name;
        $category->slug         =       Str::slug($request->name);
        if ($request->has("image")) {
            if (file_exists("uploads/categories/" . $category->image)) {
                File::delete("uploads/categories/" . $category->image);
            }
            $imageName  = "category_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/categories/'), $imageName);
            $category->image    =  $imageName;
        }
        $category->update();

        $data['message']        =       auth()->user()->name." has updated category '$category->name' to '$request->name' ";
        $data['action']         =       "updated";
        $data['module']         =       "category";
        $data['object']         =       $category;
        saveLogs($data);
        Session::flash("success","Category Updated");

        return redirect(route("category.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("superAdmin",auth()->user());
        $object                      =   Category::find($id);
        if(empty($object))
        {
            Session::flash("error","Data not found");
            return back();
        }

        $data['message']             =   auth()->user()->name." has deleted '$object->name' category";
        $data['action']              =   "deleted";
        $data['module']              =   "category";
        $data['object']              =    $object;
        saveLogs($data);
        if (file_exists("uploads/categories/" . $object->image)) {
            File::delete("uploads/categories/" . $object->image);
        }
        $object->delete();
        Session::flash("success","Category Deleted");
        return redirect(route("category.index"));
    }


}
