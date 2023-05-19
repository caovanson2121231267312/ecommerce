<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
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
            'card_name' => [
                'required', 'max:100', 'min:2',
                Rule::unique('payments', 'card_name')->ignore($this->payment)
            ],
            'user_name' => [
                'required', 'max:100', 'min:2',
            ],
            'phone_number' => [
                'required', 'max:100', 'min:2',
            ],
            'card_number' => [
                'required', 'max:100', 'min:2',
                Rule::unique('payments', 'card_number')->ignore($this->payment)
            ],
        ];
    }
}
