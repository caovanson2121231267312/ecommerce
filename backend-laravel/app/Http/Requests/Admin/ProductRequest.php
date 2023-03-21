<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends ApiRequest
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
                'required', 'max:400', 'min:2',
                Rule::unique('products', 'name')->ignore($this->product)
            ],
            'category_id' => 'required',
            'description' => 'required|min:2',
            'images' => 'required',
            "price" => 'required|min:4',
            "sale" => 'required',
            'content' => 'required|min:2',
            'sale' => 'required',
            'status' => 'required',
            'quantity' => 'required',
            'time_sale' => 'required',
            'infor' => 'required',
        ];
    }
}