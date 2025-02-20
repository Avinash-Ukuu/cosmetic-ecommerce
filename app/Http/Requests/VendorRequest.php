<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'name'                  => 'required|string|max:255',
            'email'                 => "required|unique:vendors,email,$id,id",
            'gender'                => 'required|string|max:60',
            'dob'                   => 'required|date',
            'residential_address'   => 'required|string',
            'city'                  => 'required|string|max:255',
            'phone_number'          => 'required|string|max:20',
            'aadhar_card'           => 'nullable|file|mimes:pdf|max:2048',
            'dl'                    => 'nullable|file|mimes:pdf|max:2048',
            'voter_card'            => 'nullable|file|mimes:pdf|max:2048',
            'store_name'            => 'required|string|max:255',
            'store_address'         => 'required|string',
            'business_type'         => 'required|string|max:255',
            'vendor_type'           => 'required|string|max:255',
        ];
    }
}
