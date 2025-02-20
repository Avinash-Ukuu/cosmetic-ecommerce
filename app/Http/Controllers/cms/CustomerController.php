<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->hasRole('admin'),403);

        if ($request->ajax()) {
            $data               =    Customer::with(['user' => function ($query) {
                                        $query->withoutGlobalScope('active');
                                    }])->select('*');

            if ($request->order == null) {
                $data           =   $data->orderBy('created_at', 'desc');
            }

            return DataTables::of($data)
                ->filterColumn('name', function ($query, $keyword) {
                    $query->whereHas('user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('email', function ($query, $keyword) {
                    $query->whereHas('user', function ($q) use ($keyword) {
                        $q->where('email', 'like', "%{$keyword}%");
                    });
                })
                ->editColumn('customer', function ($data) {
                    if (!empty($data->user->profile_pic) && file_exists("uploads/users/" . $data->user->profile_pic)) {
                        $imagePath  =  asset('uploads/users/' . $data->user->profile_pic);
                        return '<img src="' . $imagePath . '" alt="image">';
                    } else {
                        $defaultImage = asset('images/default.png');
                        return '<img src="' . $defaultImage . '" alt="image">';
                    }
                })
                ->editColumn('name', function ($data) {
                    return $data->user->name ?? '';
                })
                ->editColumn('email', function ($data) {
                    return $data->user->email ?? '';
                })
                ->editColumn('about', function ($data) {
                    return '<a href="' . route('customer.show', ['customer' => $data->id]) . '"><i
                    class="mdi mdi-information-outline"></i></a>';
                })
                ->rawColumns(['customer', 'name', 'email','about'])
                ->make(true);
        }

        return view('cms.customer.index');
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
        $user                   =       new User();
        $user->name             =       $request->name;
        $user->email            =       $request->email;
        $password               =       Str::random(8);
        $user->password         =       Hash::make($password);
        $user->is_active        =       1;
        if ($request->has("profile_pic")) {
            $imageName  = "user_" . Carbon::now()->timestamp . '.' . $request->file('profile_pic')->getClientOriginalExtension();
            $request->file('profile_pic')->move(public_path('uploads/users/'), $imageName);
            $user->profile_pic   =  $imageName;
        }
        $user->save();

        $customer               =       new Customer();
        $customer->user_id      =       $user->id;
        $customer->phone_number =       $request->phone_number;
        $customer->save();

        // $address                =       new Address();
        // $address->customer_id   =       $customer->id;
        // $address->address_line1 =       $request->address_line1;
        // $address->address_line2 =       $request->address_line2;
        // $address->city          =       $request->city;
        // $address->state         =       $request->state;
        // $address->zip_code      =       $request->zip_code;
        // $address->country       =       $request->country;
        // $address->save();

        return response()->json(['success' => '200', 'message' => 'Customer Data Stored']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(!auth()->user()->hasRole('admin'),403);

        $data['customer']       =       Customer::with([
                                                        'user' => function ($query) {
                                                            $query->withoutGlobalScope('active');
                                                        },
                                                        'addresses'
                                                    ])->find($id);
        if(empty($data['customer']))
        {
            Session::flash('error','Data not found');
            return redirect(route('customer.index'));
        }

        return view('cms.customer.show',$data);
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
     *
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
