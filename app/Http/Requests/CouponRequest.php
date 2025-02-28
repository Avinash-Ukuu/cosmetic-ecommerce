<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id=0;
        if(request()->has('id')){$id=request()->id;}
        return [
            'name'          => 'required|string|max:255',
            'code'          => "required|string|unique:coupons,code,$id,id",
            'discount'      => 'required|numeric|min:0',
            'discount_type' => 'required',
            'minimum_purchase'   => 'required',
            'expiry_date'   => 'required|date|after_or_equal:today',
        ];
    }
}
