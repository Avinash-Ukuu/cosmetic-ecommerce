<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModuleRequest;
use Illuminate\Support\Facades\Session;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("superAdmin",new User());
        $data['modules']  =   Module::all();

        return view("cms.module.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize("superAdmin",new User());
        $data['object']     =   new Module();
        $data['url']        =   route("module.store");
        $data['method']     =   "POST";

        return view("cms.module.form",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModuleRequest $request)
    {
        $this->authorize("superAdmin",new User());
        $module                   =   new Module();
        $module->name             =   $request->name;
        $module->save();
        $data['message']        =   auth()->user()->name." has created '$module->name' module";
        $data['action']         =   "created";
        $data['module']         =   "module";
        $data['object']         =   $module;
        saveLogs($data);
        Session::flash("success","Module Created");

        return redirect(route("module.index"));
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
        $data['object']     =   Module::find($id);
        if(empty($data['object']))
        {
            Session::flash("error","Module Already Deleted");
            return back();
        }
        $data['url']        =   route("module.update",['module'=>$id]);
        $data['method']     =   "PUT";

        return view("cms.module.form",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModuleRequest $request, string $id)
    {
        $this->authorize("superAdmin",new User());
        $module                   =   Module::find($id);
        if(empty($module))
        {
            Session::flash("error","Module Already Deleted");
            return redirect(route("module.index"));
        }
        $data['message']        =   auth()->user()->name." has updated role '$module->name' to '$request->name'";
        $data['action']         =   "updated";
        $data['module']         =   "module";
        $data['object']         =   $module;
        saveLogs($data);
        $module->name             =   $request->name;
        $module->update();
        Session::flash("success","Module Updated");

        return redirect(route("module.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("superAdmin",new User());
        $module                   =   Module::find($id);
        if(empty($module))
        {
            Session::flash("error","Module Already Deleted");
            return back();
        }
        $data['message']          =   auth()->user()->name." has deleted '$module->name' module";
        $data['action']           =   "deleted";
        $data['module']           =   "module";
        $data['object']           =   $module;
        saveLogs($data);
        Permission::where('module_id',$module->id)->delete();
        $module->delete();
        Session::flash("success","Module Deleted");

        return redirect(route("module.index"));
    }
}
