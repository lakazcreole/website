<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountItemProduct extends Model
{
    protected $fillable = [ 'discount_item_id', 'product_id' ];
}
