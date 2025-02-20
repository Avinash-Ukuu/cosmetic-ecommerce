<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("superAdmin",new User());
        $data['permissions']  =   Permission::with("module")->get();

        return view("cms.permission.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize("superAdmin",new User());
        $data['object']         =   new Permission();
        $data['modules']        =   Module::all()->pluck("name","id")->toArray();
        $data['url']            =   route("permission.store");
        $data['method']         =   "POST";

        return view("cms.permission.form",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        $this->authorize("superAdmin",new User());
        $duplicatePermission                =   Permission::where(['module_id'=>$request->module_id,'name'=>strtolower($request->name)])->exists();
        if($duplicatePermission){return back()->with("error","Permission already exists");}
        $permission                         =   new Permission();
        $permission->module_id              =   $request->module_id;
        $permission->name                   =   strtolower($request->name);
        $permission->description            =   $request->description;
        $permission->save();
        $data['message']        =   auth()->user()->name." has created '$permission->name'";
        $data['action']         =   "created";
        $data['module']         =   "permission";
        $data['object']         =   $permission;
        saveLogs($data);
        Session::flash("success","Permission Created");

        return redirect(route("permission.index"));
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
        $this->authorize("superAdmin",new User());
        $data['object']     =   Permission::with("module")->find($id);
        if(empty($data['object']))
        {
            Session::flash("error","Permission Already Deleted");
            return back();
        }
        $data['modules']    =   Module::all()->pluck("name","id")->toArray();
        $data['url']        =   route("permission.update",['permission'=>$id]);
        $data['method']     =   "PUT";

        return view("cms.permission.form",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, string $id)
    {
        $this->authorize("superAdmin",new User());
        $duplicatePermission                =   Permission::where("id","<>",$id)->
        where(['module_id'=>$request->module_id,'name'=>strtolower($request->name)])->exists();
        if($duplicatePermission){return back()->with("error","Permission already exists");}
        $permission                         =   Permission::find($id);
        if(empty($permission))
        {
            Session::flash("error","Permission Already Deleted");
            return redirect(route("permission.index"));
        }
        $data['message']                    =   auth()->user()->name." has updated '$permission->name' to '$request->name'";
        $data['action']                     =   "updated";
        $data['module']                     =   "permission";
        $data['object']                     =   $permission;
        saveLogs($data);
        $permission->module_id              =   $request->module_id;
        $permission->name                   =   strtolower($request->name);
        $permission->description            =   $request->description;
        $permission->update();
        Session::flash("success","Permission Updated");

        return redirect(route("permission.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("superAdmin",new User());
        $permission                         =   Permission::find($id);
        if(empty($permission))
        {
            Session::flash("error","Permission Already Deleted");
            return back();
        }
        $permission->roles()->detach();
        $data['message']        =   auth()->user()->name." has deleted '$permission->name'";
        $data['action']         =   "deleted";
        $data['module']         =   "permission";
        $data['object']         =   $permission;
        saveLogs($data);
        $permission->delete();
        Session::flash("success","Permission Deleted");

        return redirect(route("permission.index"));
    }
}
