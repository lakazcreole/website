<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DeliveryTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ((strtotime($value) < strtotime('11:00')) or
            ((strtotime($value) > strtotime('13:00')) and (strtotime($value) < strtotime('19:00'))))
        {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.delivery_time');
    }
}
