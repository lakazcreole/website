<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOffer extends FormRequest
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
        // dd($this->offer);
        return [
            'name' => 'required|unique:offers,name,' . $this->offer->id,
            'product' => 'required|exists:products,id',
            'begin_date' => 'required|date_format:d/m/Y|before:end_date',
            'end_date' => 'required|date_format:d/m/Y',
            'enabled' => 'required|boolean',
            'image' => 'image'
        ];
    }
}
