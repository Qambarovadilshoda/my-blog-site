<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'regex:/^[\pL\s\-\']+$/u|min:5',
            'username' => '',
            'email'=> 'email',
            'old_password' => '',
            'new_password' => '',
            'avatar'=> 'mimes:png,jpg|max:2048',
        ];
    }
}
