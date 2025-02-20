<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Mail\UserMail;
use App\Models\Vendor;
use App\Mail\CommonMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->hasRole('admin'),403);
        if ($request->ajax()) {
            $data               =    Vendor::with('user')->select('*');

            if ($request->order == null) {
                $data           =   $data->orderBy('created_at', 'desc');
            }

            return DataTables::of($data)
                ->editColumn('vendor', function ($data) {
                    if (!empty($data->user->profile_pic) && file_exists("uploads/users/" . $data->user->profile_pic)) {
                        $imagePath  =  asset('uploads/users/' . $data->user->profile_pic);
                        return '<img src="' . $imagePath . '" alt="image">';
                    } else {
                        $defaultImage = asset('images/default.png');
                        return '<img src="' . $defaultImage . '" alt="image">';
                    }
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == 'approved') {
                        return '<span class="badge badge-outline-success">Approved</span>';
                    } else if($data->status == 'rejected'){
                        return '<span class="badge badge-outline-danger">Rejected</span>';
                    }else{
                        return '<span class="badge badge-outline-warning badge-fw">Pending</span>';
                    }
                })
                ->editColumn('about', function ($data) {
                    return '<a href="' . route('vendor.show', ['vendor' => $data->id]) . '"><i
                    class="mdi mdi-information-outline"></i></a>';
                })
                ->editColumn('action', function ($data) {
                    $editUrl        =   route('vendor.edit', ['vendor' => $data->id]);
                    $btn            =   '<div class="row">';
                    $btn            .=  '<a href="' . $editUrl . '"><i class="fa fa-edit"></i></a>';
                    $btn            .=  '</div>';
                    return $btn;
                })
                ->rawColumns(['vendor', 'status', 'about', 'action'])
                ->make(true);
        }

        return view('cms.vendor.index');
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
    public function store(VendorRequest $request)
    {
        $emailValidate                  =       User::where('email', $request->email)->first();
        if(!empty($emailValidate))
        {
            Session::flash("error", "Email already exist.");
            // return redirect(route("vendor.index"));
            return back();
        }
        $vendor                         =       new Vendor();
        $vendor->name                   =       $request->name;
        $vendor->email                  =       $request->email;
        $vendor->gender                 =       $request->gender;
        $vendor->dob                    =       $request->dob;
        $vendor->residential_address    =       $request->residential_address;
        $vendor->city                   =       $request->city;
        $vendor->phone_number           =       $request->phone_number;
        $vendor->store_name             =       $request->store_name;
        $vendor->store_address          =       $request->store_address;
        $vendor->business_type          =       $request->business_type;
        $vendor->vendor_type            =       $request->vendor_type;
        $vendor->status                 =       'pending';

        if ($request->has("aadhar_card")) {
            $aadharCardName             =       $vendor->name."_"."aadhar_card" . Carbon::now()->timestamp . '.' . $request->file('aadhar_card')->getClientOriginalExtension();
            $request->file('aadhar_card')->move(public_path('uploads/vendorDocuments/'.$vendor->id.'/'), $aadharCardName);
            $vendor->aadhar_card        =       $aadharCardName;
        }
        if ($request->has("dl")) {
            $dlFileName                 =       $vendor->name."_"."dl" . Carbon::now()->timestamp . '.' . $request->file('dl')->getClientOriginalExtension();
            $request->file('dl')->move(public_path('uploads/vendorDocuments/'.$vendor->id.'/'), $dlFileName);
            $vendor->dl                 =       $dlFileName;
        }
        if ($request->has("voter_card")) {
            $voterCardName              =       $vendor->name."_"."voter_card" . Carbon::now()->timestamp . '.' . $request->file('voter_card')->getClientOriginalExtension();
            $request->file('voter_card')->move(public_path('uploads/vendorDocuments/'.$vendor->id.'/'), $voterCardName);
            $vendor->voter_card         =       $voterCardName;
        }
        $vendor->save();

        $data['vendorName'] =   $vendor->name;
        $data['subject']    =   'Vendor Registration on Learntribe';
        $data['body']       =   "<p>Thank you for registering as a vendor on [Your Website Name]. We are excited about the possibility of partnering with you and offering your products to our customers.</p><br>
                                 <p>We wanted to inform you that your registration is currently under review. Our team is working diligently to verify your details and ensure that everything is in order. This process is usually completed within [number of days, e.g., 2-3 business days], and we will notify you as soon as your account has been approved.<p><br>
                                <p>In the meantime, if you have any questions or need further assistance, please don't hesitate to contact our support team at [support email/phone number]. We are here to help!</p><br>
                                <p>Thank you for your patience, and we look forward to working with you.</p><br>";
        Mail::to($vendor->email)->send(new CommonMail($data));

        return response()->json(['success' => '200', 'message' => 'Vendor Data Stored']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(!auth()->user()->hasRole('admin'),403);
        $data['vendor']         =       Vendor::find($id);
        if(empty($data['vendor']))
        {
            Session::flash('error', 'Data not found');

            return back();
        }

        return  view('cms.vendor.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!auth()->user()->hasRole('admin'),403);
        $data['object']         =        Vendor::find($id);

        if(empty($data['object']))
        {
            Session::flash('error', 'Data not found');
            return back();
        }
        $data['method']         =       'PUT';
        $data['url']            =       route('vendor.update',['vendor'=>$id]);
        $data['businessTypes']  =       ['Manufacture/design products'=>'Manufacture/design products','Reseller of products'=>'Reseller of products','Deal in raw materials'=>'Deal in raw materials','Others'=>'Others'];

        return view('cms.vendor.form',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VendorRequest $request, string $id)
    {
        abort_if(!auth()->user()->hasRole('admin'),403);
        $vendor                         =       Vendor::find($id);
        if(empty($vendor))
        {
            Session::flash('error','Data not found');

            return back();
        }

        $vendor->name                   =       $request->name;
        $vendor->email                  =       $request->email;
        $vendor->gender                 =       $request->gender;
        $vendor->dob                    =       $request->dob;
        $vendor->residential_address    =       $request->residential_address;
        $vendor->city                   =       $request->city;
        $vendor->phone_number           =       $request->phone_number;
        $vendor->store_name             =       $request->store_name;
        $vendor->store_address          =       $request->store_address;
        $vendor->business_type          =       $request->business_type;
        if ($request->has("aadhar_card")) {
            if (file_exists("uploads/vendorDocuments/" . $vendor->id . "/" . $vendor->aadhar_card)) {
                File::delete("uploads/vendorDocuments/" . $vendor->id . "/" . $vendor->aadhar_card);
            }
            $aadharCardName             =       $vendor->name."_"."aadhar_card" . Carbon::now()->timestamp . '.' . $request->file('aadhar_card')->getClientOriginalExtension();
            $request->file('aadhar_card')->move(public_path('uploads/vendorDocuments/'.$vendor->id.'/'), $aadharCardName);
            $vendor->aadhar_card        =       $aadharCardName;
        }
        if ($request->has("dl")) {
            if (file_exists("uploads/vendorDocuments/" . $vendor->id . "/" . $vendor->dl)) {
                File::delete("uploads/vendorDocuments/" . $vendor->id . "/" . $vendor->dl);
            }
            $dlFileName                 =       $vendor->name."_"."dl" . Carbon::now()->timestamp . '.' . $request->file('dl')->getClientOriginalExtension();
            $request->file('dl')->move(public_path('uploads/vendorDocuments/'.$vendor->id.'/'), $dlFileName);
            $vendor->dl                 =       $dlFileName;
        }
        if ($request->has("voter_card")) {
            if (file_exists("uploads/vendorDocuments/" . $vendor->id . "/" . $vendor->voter_card)) {
                File::delete("uploads/vendorDocuments/" . $vendor->id . "/" . $vendor->voter_card);
            }
            $voterCardName              =       $vendor->name."_"."voter_card" . Carbon::now()->timestamp . '.' . $request->file('voter_card')->getClientOriginalExtension();
            $request->file('voter_card')->move(public_path('uploads/vendorDocuments/'.$vendor->id.'/'), $voterCardName);
            $vendor->voter_card         =       $voterCardName;
        }
        $vendor->update();
        Session::flash('success','Data Upated');

        return redirect(route('vendor.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateVendorStatus(Request $request,$id)
    {
        abort_if(!auth()->user()->hasRole('admin'),403);
        $request->validate(['status'=>'required']);
        $vendor                 =       Vendor::find($id);
        if(empty($vendor))
        {
            Session::flash('error', 'Data not found');
            return back();
        }

        $emailValidate          =       User::where('email', $vendor->email)->first();
        if(!empty($emailValidate))
        {
            Session::flash("error", "Vendor already exist.");
            return redirect(route("vendor.index"));
        }

        $vendor->status         =       $request->status;
        if($request->has('reason') && $request->status == 'rejected' )
        {
            $vendor->reason     =       $request->reason;
        }
        $vendor->update();

        if($vendor->status  ==  'approved')
        {
            $user               =       new User();
            $user->name         =       $vendor->name;
            $user->email        =       $vendor->email;
            $user->is_active    =       1;
            $password           =       Str::random(8);
            $user->password     =       Hash::make($password);
            $user->vendor_id    =       $vendor->id;
            // if (!empty($vendor->profile_pic) && file_exists("uploads/vendors/" . $vendor->profile_pic)) {
            //     $vendorProfilePicPath = public_path('uploads/vendors/' . $vendor->profile_pic);
            //     $userProfilePicName = 'user_' . Carbon::now()->timestamp . '.' . pathinfo($vendor->profile_pic, PATHINFO_EXTENSION);
            //     $userProfilePicPath = public_path('uploads/users/' . $userProfilePicName);

            //     if (file_exists($vendorProfilePicPath)) {
            //         if (!file_exists(public_path('uploads/users'))) {
            //             mkdir(public_path('uploads/users'), 0755, true);
            //         }

            //         copy($vendorProfilePicPath, $userProfilePicPath);
            //         $user->profile_pic = $userProfilePicName;
            //     }
            // }
            $user->save();

            $role               =       Role::where('name','vendor')->first();
            if(!empty($role))
            {
                $user->roles()->attach($role->id);
            }
            // Mail::to($user->email)->send(new UserMail($user,$password));
        }
        else if($vendor->status == 'rejected')
        {
            $data['vendorName'] =   $vendor->name;
            $data['subject']    =   'Vendor request rejected';
            $data['body']       =   "<p>Sorry You are Rejected.</p><br>
                                    <p><b>Reason : </b> {{ $vendor->reason }} .<p><br>
                                    <p>Thank you for your patience.</p><br>";

            Mail::to($vendor->email)->send(new CommonMail($data));
        }

        $data['message']        =   auth()->user()->name . " has updated '$vendor->name' status";
        $data['action']         =   "updated";
        $data['module']         =   "vendor";
        $data['object']         =   $vendor;
        saveLogs($data);
        Session::flash('success','Data Updated');

        return back();
    }
}
