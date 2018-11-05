<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountItem extends Model
{
    protected $fillable = [ 'percent', 'required', 'discount_id' ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
