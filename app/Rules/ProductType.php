<?php

namespace App\Rules;

use App\Product;
use Illuminate\Contracts\Validation\Rule;

class ProductType implements Rule
{
    private $types;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->types = array_map(function($productType) {
            return $productType['type'];
        }, Product::TYPES);
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
        return in_array($value, $this->types);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.product_type');
    }
}
