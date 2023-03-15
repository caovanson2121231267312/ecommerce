<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoucherRequest extends ApiRequest
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
            'title' => [
                'required', 'max:100', 'min:2',
                Rule::unique('vouchers', 'title')->ignore($this->voucher)
            ],
            'content' => 'required|min:2',
            'sale' => 'required|integer',
            'time_limit' => 'required|date',
        ];
    }
}
