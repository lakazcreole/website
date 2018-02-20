<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'totalPrice'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
