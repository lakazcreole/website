<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscount extends FormRequest
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
            'name' => 'required|unique:discounts,name',
            'description' => 'required',
            'items' => 'required|array|min:1',
            'items.*.percent' => 'required|numeric|min:0|max:100',
            'items.*.required' => 'required|boolean',
            'items.*.products' => 'required|array|min:1|exists:products,id',
        ];
    }
}
