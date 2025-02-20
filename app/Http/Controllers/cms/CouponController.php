<?php

namespace App\Http\Controllers\cms;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['coupons']        =       Coupon::orderBy('created_at','desc')->get();

        return view('cms.coupon.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['object']         =       new Coupon();
        $data['method']         =       'POST';
        $data['url']            =       route('coupon.store');

        return view('cms.coupon.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        $coupon                     =       new Coupon();
        $coupon->name               =       $request->name;
        $coupon->code               =       $request->code;
        $coupon->discount           =       $request->discount;
        $coupon->discount_type      =       $request->discount_type;
        $coupon->minimum_purchase   =       $request->minimum_purchase;
        $coupon->expiry_date        =       $request->expiry_date;
        $coupon->usage_limit        =       $request->usage_limit;
        $coupon->coupon_type        =       $request->coupon_type;
        $coupon->is_active          =       1;
        $coupon->save();

        $data['message']            =       auth()->user()->name . " has craeted the $coupon->name coupon";
        $data['action']             =       "craeted";
        $data['module']             =       "coupon";
        $data['object']             =       $coupon;
        saveLogs($data);

        Session::flash('success','Coupon Created');

        return redirect(route('coupon.index'));
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
        $data['object']         =       Coupon::find($id);
        if(empty($data['object']))
        {
            Session::flash('error','Data not found');
            return back();
        }
        $data['method']         =       'PUT';
        $data['url']            =       route('coupon.update',['coupon'=>$id]);

        return view('cms.coupon.form',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, string $id)
    {
        $coupon                     =       Coupon::find($id);
        if(empty($coupon))
        {
            Session::flash('error','Data not found');
            return back();
        }
        $coupon->name               =       $request->name;
        $coupon->code               =       $request->code;
        $coupon->discount           =       $request->discount;
        $coupon->discount_type      =       $request->discount_type;
        $coupon->minimum_purchase   =       $request->minimum_purchase;
        $coupon->expiry_date        =       $request->expiry_date;
        $coupon->usage_limit        =       $request->usage_limit;
        $coupon->coupon_type        =       $request->coupon_type;
        $coupon->update();

        $data['message']            =       auth()->user()->name . " has updated the $coupon->name coupon";
        $data['action']             =       "updated";
        $data['module']             =       "coupon";
        $data['object']             =       $coupon;
        saveLogs($data);

        Session::flash('success','Coupon Created');

        return redirect(route('coupon.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
