<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscount extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:discounts,name' . $this->discount->id,
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.percent' => 'numeric|min:0|max:100',
            'products.*.max_items' => 'numeric|min:1',
            'products.*.required' => 'boolean',
        ];
    }
}
