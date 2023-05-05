<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\Admin\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends ApiRequest
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
            'rate' => ['required'],
            'content' => 'required|min:2|max:1000',
            'product_id' => 'required',
        ];
    }
}
