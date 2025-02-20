<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|integer',
            'sale_price'    => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'description'   => 'required|string',
            // 'unit'          => 'required|string|max:10',
            'weight'        => 'required',
            'quantity'      => 'required|integer',
            'images.*'      => 'mimes:jpeg,png,jpg,gif,mp4|max:2048',
            'colors'        => 'sometimes|array',
            'colors.*'      => 'required_with:colors|string|distinct|max:100',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'The product name is required.',
            'category_id.required'  => 'The product category is required.',
            'sale_price.required'   => 'The price is required.',
            'images.*.image'        => 'Each file must be an image.',
            'images.*.mimes'        => 'Each image must be of type jpeg, png, jpg, or gif.',
            'images.*.max'          => 'Each image must not exceed 2MB.',
            'colors.*.required_with'=> 'If a color is added, all color fields must be filled.',
            'colors.*.distinct'     => 'Each color must be unique.',
            'colors.*.max'          => 'Each color may not be greater than 100 characters.',
        ];
    }
}
