<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => "required|min:3|max:30",
            'email' => [
                'required', 'max:100', 'min:2',
                Rule::unique('users', 'email')->ignore($this->user)
            ],
            'phone_number' => [
                'required', 'max:20', 'min:8',
                Rule::unique('users', 'phone_number')->ignore($this->user)
            ],
            'dob' => 'required|date',
            // 'gender' => 'required',
            'roles' => 'required',
            'password' => 'min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6'
        ];
    }
}
