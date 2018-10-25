<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromoCode extends FormRequest
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
            'name' => 'required|unique:promo_codes,name',
            'maxUses' => 'required|numeric|min:1',
            'discountId' => 'required|exists:discounts,id',
            'beginAt' => 'required|date_format:d/m/Y|before:end_at',
            'endAt' => 'required|date_format:d/m/Y',
        ];
    }
}
