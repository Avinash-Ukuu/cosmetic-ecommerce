<?php

namespace App\Http\Controllers\api;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Address;
use App\Models\Customer;
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


            $token          =   bin2hex(random_bytes(32));
            $user           =   User::create([
                'name'      => $validatedData['name'],
                'email'     => $validatedData['email'],
                'is_active' => 1,
                'password'  => Hash::make($validatedData['password']),
                'api_token' => $token
            ]);

            $customer       =   Customer::create([
                'user_id'       =>  $user->id,
                'phone_number'  =>  $validatedData['phone_number'],
            ]);

            $role           =   Role::where('name','customer')->first();
            if(!empty($role))
            {
                $user->roles()->attach($role->id);
            }

            // Mail::to($user->email)->send(new CustomerRegisterMail($user));

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

        $user->load(['customer', 'roles']);

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
        // $token  = $request->header('authorization');

        // if (empty($token)) {
        //     return response()->json(['message' => 'Token missing'], 401);
        // }

        // $user   = User::with('customer')->where('api_token', $token)->first();

        $user = Auth::user();
        if(empty($user))
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData  =   $request->validate([
                                    'addresses' => 'required|array',
                                    'addresses.*.address_line1' => 'required|string',
                                    'addresses.*.address_line2' => 'nullable|string',
                                    'addresses.*.city' => 'required|string|max:255',
                                    'addresses.*.state' => 'required|string|max:255',
                                    'addresses.*.zip_code' => 'required|string|max:10',
                                    'addresses.*.country' => 'required|string|max:255',
                                ]);

        $addresses = [];
        foreach ($validatedData['addresses'] as $addressData) {
            $addresses[] = Address::create([
                'customer_id'       =>      $user->customer->id,
                'address_line1'     =>      $addressData['address_line1'],
                'address_line2'     =>      $addressData['address_line2'],
                'city'              =>      $addressData['city'],
                'state'             =>      $addressData['state'],
                'zip_code'          =>      $addressData['zip_code'],
                'country'           =>      $addressData['country'],
            ]);
        }

        return response()->json(['message' => 'Address stored'], 200);
    }
}
