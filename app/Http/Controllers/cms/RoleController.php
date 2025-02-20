<?php

namespace App\Http\Controllers\cms;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("userManager", new User());
        $data['roles']  =   Role::all();

        return view("cms.role.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize("userManager", new User());
        $data['object']     =   new Role();
        $data['url']        =   route("role.store");
        $data['method']     =   "POST";

        return view("cms.role.form",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $this->authorize("userManager", new User());
        $role                   =   new Role();
        $role->name             =   strtolower($request->name);
        $role->description      =   $request->description;
        $role->save();
        $data['message']        =   auth()->user()->name." has created '$role->name' role";
        $data['action']         =   "created";
        $data['module']         =   "role";
        $data['object']         =   $role;
        saveLogs($data);
        Session::flash("success","Role Created");
        return redirect(route("role.index"));
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
        $this->authorize("userManager", new User());
        $data['object']     =   Role::find($id);
        if(empty($data['object']))
        {
            Session::flash("error","Role Already Deleted");
            return back();
        }
        $data['url']        =   route("role.update",['role'=>$id]);
        $data['method']     =   "PUT";

        return view("cms.role.form",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $this->authorize("userManager", new User());
        $role                   =   Role::find($id);
        if(empty($role))
        {
            Session::flash("error","Role Already Deleted");
            return redirect(route("role.index"));
        }
        $data['message']        =   auth()->user()->name." has updated role '$role->name' to '$request->name'";
        $data['action']         =   "updated";
        $data['module']         =   "role";
        $data['object']         =   $role;
        saveLogs($data);
        $role->name             =   strtolower($request->name);
        $role->description      =   $request->description;
        $role->update();
        Session::flash("success","Role Updated");

        return redirect(route("role.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("superAdmin", new User());
        $role                   =   Role::find($id);
        if(empty($role))
        {
            Session::flash("error","Role Already Deleted");
            return back();
        }
        $role->permissions()->detach();
        $data['message']        =   auth()->user()->name." has deleted '$role->name' role";
        $data['action']         =   "deleted";
        $data['module']         =   "role";
        $data['object']         =   $role;
        saveLogs($data);
        $role->delete();
        Session::flash("success","Role Deleted");

        return redirect(route("role.index"));
    }

    public function assignPermissionForm(Request $request)
    {
        $this->authorize("userManager",new User());
        $data['role']                   =   Role::with('permissions')->find($request->id);
        if(empty($data['role']))
        {
            Session::flash("error","Role Already Deleted");
            return back();
        }
        $data['assignedPermissions']    =   $data['role']->permissions->isEmpty() ? [] : $data['role']->permissions->pluck("name","id")->toArray();
        $data['modulePermissions']      =   Permission::with("module")->get()->groupBy("module.name");
        return view("cms.role.assignPermission",$data);
    }

    public function assignPermission(Request $request)
    {
        $this->authorize("userManager",new User());
        $role                   =   Role::find($request->id);
        if(empty($role))
        {
            Session::flash("error","Role Already Deleted");
            return redirect(route("role.index"));
        }
        $role->permissions()->sync($request->permission_id);
        $data['message']        =   auth()->user()->name." has assigned permissions to '$role->name' role";
        $data['action']         =   "assigned";
        $data['module']         =   "role";
        $data['object']         =   $role;
        saveLogs($data);
        Session::flash('success','Permissions Assigned Successfully');
        return back();
    }
}
