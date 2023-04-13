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
            'name' => [
                'required', 'max:100', 'min:2',
                Rule::unique('users', 'name')->ignore($this->user)
            ],
            'phone_number' => 'required|min:10|max:20',
            'email' => 'required|email',
            'dob' => 'required|date',
            // 'gender' => 'required',
            'roles' => 'required',
        ];
    }
}
