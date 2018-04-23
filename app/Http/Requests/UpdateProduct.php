<?php

namespace App\Http\Requests;

use App\Rules\ProductType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest
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
            'name' => 'required|unique:products,name,' . $this->product->id, // ignore this products ID when checking for name uniqueness
            'type' => ['required', new ProductType],
            'pieces' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'disabled' => 'required|boolean'
        ];
    }
}
