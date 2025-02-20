<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
    public function attributes()
    {
        return [
            'module_id' => 'module',
        ];
    }

    public function rules()
    {
        return [
            'name'          => "required|string|max:255|regex:/^[\p{L}\p{M}\p{N}\p{Pd}\p{Pc}\p{Zs}]+$/u",
            'module_id'     => "required",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required.',
            'name.string'   => 'Name field should be a string.',
            'name.max'      => 'Name field should not exceed 255 characters.',
            'name.regex'    => 'Name field should only contain alphabetical characters.',
            'name.unique'   => 'The name you entered already exists in the database.',
        ];
    }
}
