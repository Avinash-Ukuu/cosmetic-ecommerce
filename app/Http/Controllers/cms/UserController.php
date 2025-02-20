<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Mail\UserMail;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize("userManager", new User());

        if ($request->ajax()) {
            $data               =    User::leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                                        ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
                                        ->select('users.*','roles.name as role_name','roles.id as role_id');

            if (!empty(auth()->user()->super_admin)) {
                $data           =   $data->withoutGlobalScope('active')->where('users.id', '<>', auth()->user()->id);
            } else {
                $data           =   $data->withoutGlobalScope('active')->where('users.id', '<>', auth()->user()->id)->where(function ($query) {
                    $query->whereNull('users.super_admin')->orWhere('users.super_admin', '0');
                });
            }
            if($request->order ==null){
                $data           =   $data->orderBy('users.created_at', 'desc');
            }

            return DataTables::of($data)
                ->filterColumn('role', function($query, $keyword) {
                    $sql = "roles.name LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->editColumn('user', function ($data) {
                    if (!empty($data->profile_pic) && file_exists("uploads/users/" . $data->profile_pic)) {
                        $imagePath  =  asset('uploads/users/' . $data->profile_pic);
                        return '<img src="' . $imagePath . '" alt="image">';
                    } else {
                        $defaultImage = asset('images/default.png');
                        return '<img src="' . $defaultImage . '" alt="image">';
                    }
                })
                ->editColumn('role', function ($data) {
                    return $data->showRoles();
                })
                ->editColumn('status', function ($data) {
                    if (isset($data->is_active)) {
                        return '<span class="badge badge-outline-success">Active</span>';
                    } else {
                        return '<span class="badge badge-outline-danger">Not Active</span>';
                    }
                })
                ->editColumn('assign_role', function ($data) {
                    return '<a href="' . route('assignRoles', ['id' => $data->id]) . '"><i
                                        class="mdi mdi-table-edit"></i></a>';
                })
                ->editColumn('action', function ($data) {
                    $editUrl        =   route('user.edit', ['user' => $data->id]);
                    $deleteUrl      =   route('user.destroy', ['user' => $data->id]);
                    $btn            =   '<div class="row">';
                    $btn            .=  '<a href="' . $editUrl . '"><i class="fa fa-edit"></i></a>';
                    if (isset(auth()->user()->super_admin)) {
                        $btn            .=  '<a style="cursor: pointer;"
                                                            onclick="deleteItem(\'' . $deleteUrl . '\')">
                                                            <i class="fa fa-trash text-danger ml-2"></i>
                                                        </a>';
                    }
                    $btn            .=  '</div>';
                    return $btn;
                })
                ->rawColumns(['user', 'role', 'status', 'assign_role', 'action'])
                ->make(true);
        }

        return view('cms.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize("userManager", new User());

        $data['object']         =   new User();
        $data['method']         =   'POST';
        $data['url']            =   route('user.store');

        return view('cms.user.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->authorize("userManager", new User());

        $user                   =   new User();
        $user->name             =   $request->name;
        $user->email            =   $request->email;
        $user->is_active        =   1;
        $password               =   Str::random(8);
        $user->password         =   Hash::make($password);
        if ($request->has("profile_pic")) {
            $imageName  = "user_" . Carbon::now()->timestamp . '.' . $request->file('profile_pic')->getClientOriginalExtension();
            $request->file('profile_pic')->move(public_path('uploads/users/'), $imageName);
            $user->profile_pic   =  $imageName;
        }
        $user->save();
        // Mail::to($user->email)->send(new UserMail($user,$password));
        $data['message']        =   auth()->user()->name . " has created '$user->name' account";
        $data['action']         =   "created";
        $data['module']         =   "user";
        $data['object']         =   $user;
        saveLogs($data);
        Session::flash("success", "User Account Created");

        return redirect(route("user.index"));
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

        $data['object']             =   User::withoutGlobalScope('active')->find($id);
        if (empty($data['object'])) {
            Session::flash("error", "User Already Deleted");
            return back();
        }
        $data['url']                =   route("user.update", ['user' => $id]);
        $data['method']             =   "PUT";

        return view("cms.user.form", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $this->authorize("userManager", new User());

        $user                   =   User::withoutGlobalScope('active')->find($id);
        if (empty($user)) {
            Session::flash("error", "User Already Deleted");
            return redirect(route("user.index"));
        }
        $user->name             =   $request->name;
        $user->email            =   $request->email;
        $user->is_active        =   $request->is_active;
        if ($request->has("profile_pic")) {
            if (file_exists("uploads/users/" . $user->profile_pic)) {
                File::delete("uploads/users/" . $user->profile_pic);
            }
            // image upload code
            $imageName  = "user_" . Carbon::now()->timestamp . '.' . $request->file('profile_pic')->getClientOriginalExtension();
            $request->file('profile_pic')->move(public_path('uploads/users/'), $imageName);
            $user->profile_pic   =  $imageName;
        }

        $user->update();

        $data['message']        =   auth()->user()->name . " has updated '$user->name' account";
        $data['action']         =   "updated";
        $data['module']         =   "user";
        $data['object']         =   $user;
        saveLogs($data);
        Session::flash("success", "User Account Updated");
        return redirect(route("user.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("superAdmin", new User());

        $user   =   User::withoutGlobalScope('active')->find($id);
        if (empty($user)) {
            Session::flash("error", "User Already Deleted");
            return back();
        }

        if (file_exists("uploads/users/" . $user->profile_pic)) {
            File::delete("uploads/users/" . $user->profile_pic);
        }
        if ($user->roles->isNotEmpty()) {
            foreach ($user->roles as $role) {
                $role->permissions()->detach();
            }
        }
        $user->roles()->detach();
        $data['message']        =   auth()->user()->name . " has deleted '$user->name' account";
        $data['action']         =   "deleted";
        $data['module']         =   "user";
        $data['object']         =   $user;
        saveLogs($data);
        $user->delete();
        Session::flash("success", "User Account Deleted");
        return redirect(route("user.index"));
    }

    public function changePassword(Request $request)
    {
        return view("cms.user.changePasswordForm");
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        $hashValue      =   Hash::make($request->password);
        auth()->user()->update(['password' => $hashValue]);
        Session::flash('success', 'Password Changed Successfully');

        return redirect(route('dashboard'));
    }

    public function assignRoleForm(Request $request)
    {
        $this->authorize("userManager", new User());
        $data['user']   =   User::withoutGlobalScope('active')->with('roles')->find($request->id);
        if (empty($data['user'])) {
            Session::flash("error", "User Already Deleted");
            return redirect(route("user.index"));
        }
        $data['roles']  =   Role::all()->pluck("name", "id")->toArray();

        return view("cms.user.assignRole", $data);
    }

    public function assignRole(Request $request)
    {
        $this->authorize("userManager", new User());
        $user                   =   User::withoutGlobalScope('active')->find($request->id);
        if (empty($user)) {
            Session::flash("error", "User Already Deleted");
            return redirect(route("user.index"));
        }
        // if (!empty($request->super_admin)) {
        //     $user->super_admin      =   !empty($request->super_admin) ? 1 : 0;
        // }
        // $user->save();
        $user->roles()->sync($request->role_id);
        $data['message']        =   auth()->user()->name . " has assigned roles to '$user->name' account";
        $data['action']         =   "assigned";
        $data['module']         =   "user";
        $data['object']         =   $user;
        saveLogs($data);
        Session::flash('success', 'Roles Assigned Successfully');

        return back();
    }

    public function switchUserForm()
    {
        abort_if(auth()->user()->cannot("superAdmin", new User()), 403);

        $users              =   User::with('roles')->where('id', '<>', auth()->user()->id)->get();

        $data['users']      =   $users->mapWithKeys(function ($user) {
                                    $roles = $user->roles->pluck('name')->implode(', ');
                                    return [$user->id => $user->name . ' (' . $roles . ')'];
                                })->toArray();

        return view('cms.user.switchUser', $data);
    }

    public function switchUser(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        if ($user) {
            session()->put('original_user', auth()->user()->id);
            auth()->loginUsingId($user->id);
        }

        Session::flash("success", "Successfully User Switch");
        return redirect(route('dashboard'));
    }

    public function logoutSwitchUser()
    {
        if (session()->has('original_user')) {
            auth()->loginUsingId(session()->get('original_user'));
            session()->forget('original_user');
        }

        Session::flash("success", "Successfully Return Back");
        return redirect(route('dashboard'));
    }

    public function profile($id)
    {
        $data['object']         =       User::with('vendor')->find($id);
        if(empty($data['object']))
        {
            Session::flash('error','Data not found');
            return back();
        }
        $data['method']         =       'PUT';
        $data['url']            =       route('storeProfile',['id'=>$id]);

        return view('cms.user.profile',$data);
    }

    public function storeProfile(Request $request,$id)
    {
        $user                       =       User::with('vendor','instructor')->find($id);
        if(empty($user))
        {
            Session::flash('error','Data not found');
            return back();
        }

        if ($request->has("profile_pic")) {
            if (file_exists("uploads/users/" . $user->profile_pic)) {
                File::delete("uploads/users/" . $user->profile_pic);
            }
            // image upload code
            $imageName              = "user_" . Carbon::now()->timestamp . '.' . $request->file('profile_pic')->getClientOriginalExtension();
            $request->file('profile_pic')->move(public_path('uploads/users/'), $imageName);
            $user->profile_pic      =  $imageName;
        }
        $user->update();

        if ($request->has('store_name') || $request->has('store_address') || $request->has('phone_number')) {
            $vendor = $user->vendor ?? new Vendor();

            // if ($request->hasFile('profile_pic')) {

            //     if (!empty($vendor->profile_pic) && file_exists(public_path("uploads/vendors/{$vendor->profile_pic}"))) {
            //         File::delete(public_path("uploads/vendors/{$vendor->profile_pic}"));
            //     }

            //     $userProfilePicPath = public_path("uploads/users/{$user->profile_pic}");
            //     $vendorProfilePicName = 'vendor_' . Carbon::now()->timestamp . '.' . pathinfo($user->profile_pic, PATHINFO_EXTENSION);
            //     $vendorProfilePicPath = public_path("uploads/vendors/{$vendorProfilePicName}");

            //     if (file_exists($userProfilePicPath)) {
            //         if (!file_exists(public_path('uploads/vendors'))) {
            //             mkdir(public_path('uploads/vendors'), 0755, true);
            //         }

            //         copy($userProfilePicPath, $vendorProfilePicPath);
            //         $vendor->profile_pic = $vendorProfilePicName;
            //     }
            // } else if (!$vendor->exists && !empty($user->profile_pic)) {

            //     $userProfilePicPath = public_path("uploads/users/{$user->profile_pic}");
            //     $vendorProfilePicName = 'vendor_' . Carbon::now()->timestamp . '.' . pathinfo($user->profile_pic, PATHINFO_EXTENSION);
            //     $vendorProfilePicPath = public_path("uploads/vendors/{$vendorProfilePicName}");

            //     if (file_exists($userProfilePicPath)) {
            //         if (!file_exists(public_path('uploads/vendors'))) {
            //             mkdir(public_path('uploads/vendors'), 0755, true);
            //         }

            //         copy($userProfilePicPath, $vendorProfilePicPath);
            //         $vendor->profile_pic = $vendorProfilePicName;
            //     }
            // }

            $vendor->name               = $user->name;
            $vendor->email              = $user->email;
            $vendor->store_name         = $request->input('store_name', $vendor->store_name);
            $vendor->store_address      = $request->input('store_address', $vendor->store_address);
            $vendor->phone_number       = $request->input('phone_number', $vendor->phone_number);
            $vendor->status             = $vendor->exists ? $vendor->status : 'approved';
            $vendor->save();

            if (!$user->vendor) {
                $user->vendor_id = $vendor->id;
                $user->update();
            }
        }
        $data['message']        =   auth()->user()->name . " has updated the profile";
        $data['action']         =   "updated";
        $data['module']         =   "user";
        $data['object']         =   $user;
        saveLogs($data);

        Session::flash('success','Data Updated');

        return back();
    }
}
