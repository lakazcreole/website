<?php

namespace App\Http\Requests;

use App\Rules\DeliveryTime;
use App\Rules\DiscountRequiredProduct;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'customer.firstName' => 'required|alpha|max:255',
            'customer.lastName' => 'required|alpha|max:255',
            'customer.email' => 'required|email',
            'customer.phone' => 'required|numeric',
            'address.address1' => 'required|max:255',
            'address.address2' => 'max:255',
            'address.address3' => 'max:255',
            'address.city' => 'required|max:255',
            'address.zip' => 'required|numeric',
            'date' => 'required|date_format:d/m/Y|after:today',
            'time' => ['required', 'date_format:H:i', new DeliveryTime],
            'orderLines' => 'required|array',
            'orderLines.*.id' => ['required', 'exists:products,id'],
            'orderLines.*.quantity' => 'required|numeric|min:1',
            'information' => 'max:255',
            'promoCode' => 'exists:promo_codes,name',
        ];
    }
}
