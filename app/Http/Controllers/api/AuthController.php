<?php

namespace App\Http\Controllers\api;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\Role;
use App\Models\User;
use App\Models\Address;
use App\Models\Customer;
use App\Mail\SendOtpMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\CustomerRegisterMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedData  = $request->validate([
                'name'          => 'required|string|max:255',
                'email'         => 'required|string|email|max:255|unique:users',
                'password'      => 'required|string|min:8',
                'phone_number'  => 'required|string|min:8',
            ]);
            // Generate OTP
            $otp        = rand(100000, 999999);
            $otp        = (string)$otp;
            $expiresAt  = Carbon::now()->addMinutes(5)->toDateTimeString();

            // Store OTP in otps table

            $otpCode                =       new Otp();
            $otpCode->email         =       $validatedData['email'];
            $otpCode->otp_code      =       $otp;
            $otpCode->expires_at    =       $expiresAt;
            $otpCode->save();
            // Send OTP to user's email
            Mail::to($validatedData['email'])->send(new SendOtpMail($otp));

            return response()->json(['message' => 'OTP sent to your email. Please verify to complete registration.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name'          => 'required|string|max:255',
                'email'         => 'required|string|email|max:255|unique:users',
                'password'      => 'required|string|min:8',
                'phone_number'  => 'required|string|min:8',
                'otp'           => 'required|integer',
            ]);

            $otpEntry       =   Otp::where('email', $validatedData['email'])
                                ->where('otp_code', $validatedData['otp'])
                                ->first();

            if (!$otpEntry) {
                return response()->json(['message' => 'Invalid OTP'], 400);
            }

            if (Carbon::now()->greaterThan($otpEntry->expires_at)) {
                return response()->json(['message' => 'OTP expired'], 400);
            }

            // Generate API token
            $token = Str::random(64);

            // Create User
            $user = User::create([
                'name'      => $validatedData['name'],
                'email'     => $validatedData['email'],
                'is_active' => 1,
                'password'  => Hash::make($validatedData['password']),
                'api_token' => $token
            ]);

            // Create Customer
            $customer = Customer::create([
                'user_id'       =>  $user->id,
                'phone_number'  =>  $validatedData['phone_number'],
            ]);

            // Assign Role
            $role = Role::where('name', 'customer')->first();
            if (!empty($role)) {
                $user->roles()->attach($role->id);
            }
            Mail::to($user->email)->send(new CustomerRegisterMail($user));
            // Delete OTP after successful verification
            $otpEntry->delete();

            return response()->json(['token' => $token, 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Login existing customer
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        $user->load(['customer.addresses','customer.wishlistProducts', 'customer.cartItems','roles']);

        // Check if the user has an associated customer profile
        if (!$user->customer) {
            return response()->json(['message' => 'Unauthorized: Customer profile missing'], 403);
        }

        // Check if the user has the required roles (e.g., customer role)
        if ($user->roles->isEmpty()) {
            return response()->json(['message' => 'Unauthorized: Role missing'], 403);
        }

        $token = bin2hex(random_bytes(32));
        $user->update(['api_token' => $token]);

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $request)
    {
        // $token = $request->header('authorization');

        // if (empty($token)) {
        //     return response()->json(['message' => 'Token missing'], 401);
        // }

        // $user = User::where('api_token', $token)->first();

        $user = Auth::user();

        if ($user) {
            $user->update(['api_token' => null]);

            return response()->json(['message' => 'Logged out successfully'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function updateProfile(Request $request)
    {
        // $token  = $request->header('authorization');

        // if (empty($token)) {
        //     return response()->json(['message' => 'Token missing'], 401);
        // }

        // $user   = User::where('api_token', $token)->first();

        $user = Auth::user();

        if ($user) {
            if($request->has('name'))
            {
                $user->name         =       $request->name;
            }

            if ($request->has("profile_pic")) {
                if (file_exists("uploads/users/" . $user->profile_pic)) {
                    File::delete("uploads/users/" . $user->profile_pic);
                }
                $imageName  = "user_" . Carbon::now()->timestamp . '.' . $request->file('profile_pic')->getClientOriginalExtension();
                $request->file('profile_pic')->move(public_path('uploads/users/'), $imageName);
                $user->profile_pic   =  $imageName;
            }
            $user->update();

            if($request->has('phone_number'))
            {
                $user->customer->phone_number = $request->phone_number;
                $user->customer->update();
            }

            $data['message']        =   $user->name . " has updated his account";
            $data['action']         =   "updated";
            $data['module']         =   "user";
            $data['object']         =   $user;
            saveLogs($data);
            return response()->json(['message' => 'Data Updated'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function storeAddress(Request $request)
    {
        $user = Auth::user();
        if(empty($user))
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $addressCount       =   Address::where('customer_id', $user->customer->id)->count();
        if ($addressCount >= 5) {
            return response()->json(['message' => 'You can only store up to 5 addresses.'], 400);
        }

        $request->validate([
                    'full_name'     => 'required|string|max:255',
                    'mobile_number' => 'nullable|string',
                    'email'         => 'required|email|max:255',
                    'building_name' => 'required|string|max:255',
                    'street_address'=> 'required|string|max:255', // Increased length to allow full address
                    'area'          => 'required|string|max:255',
                    'emirate'       => 'required|string',
                    'po_box'        => 'nullable|string|max:50', // Optional field for PO Box
                    'landmark'      => 'nullable|string|max:255', // Optional field for additional info
                    'delivery_instructions' => 'nullable|string|max:500' // Optional for additional delivery details
                ]);

        $address                        =       new Address();
        $address->customer_id           =       $user->customer->id;
        $address->full_name             =       $request->full_name;
        $address->mobile_number         =       $request->mobile_number;
        $address->email                 =       $request->email;
        $address->building_name         =       $request->building_name;
        $address->street_address        =       $request->street_address;
        $address->street_address        =       $request->street_address;
        $address->area                  =       $request->area;
        $address->emirate               =       $request->emirate;
        $address->po_box                =       $request->po_box;
        $address->landmark              =       $request->landmark;
        $address->delivery_instructions =       $request->delivery_instructions;
        $address->save();

        return response()->json($address, 200);
    }

    public function updateAddress(Request $request)
    {
        $user = Auth::user();
        if(empty($user))
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $request->validate([
                'address_id'    => 'required|exists:addresses,id',
                'full_name'     => 'required|string|max:255',
                'mobile_number' => 'nullable|string',
                'email'         => 'required|email|max:255',
                'building_name' => 'required|string|max:255',
                'street_address'=> 'required|string|max:255', // Increased length to allow full address
                'area'          => 'required|string|max:255',
                'emirate'       => 'required|string',
                'po_box'        => 'nullable|string|max:50', // Optional field for PO Box
                'landmark'      => 'nullable|string|max:255', // Optional field for additional info
                'delivery_instructions' => 'nullable|string|max:500' // Optional for additional delivery details
            ]);

        $address            =   Address::where('id', $request->address_id)
                                ->where('customer_id', $user->customer->id)
                                ->first();

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->full_name             =       $request->full_name;
        $address->mobile_number         =       $request->mobile_number;
        $address->email                 =       $request->email;
        $address->building_name         =       $request->building_name;
        $address->street_address        =       $request->street_address;
        $address->street_address        =       $request->street_address;
        $address->area                  =       $request->area;
        $address->emirate               =       $request->emirate;
        $address->po_box                =       $request->po_box;
        $address->landmark              =       $request->landmark;
        $address->delivery_instructions =       $request->delivery_instructions;
        $address->update();

        return response()->json($address, 200);
    }

    public function getAddress()
    {
        $user = Auth::user();
        if(empty($user))
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $addresses      =       $user->customer->addresses;

        return  response()->json($addresses,200);

    }
}
