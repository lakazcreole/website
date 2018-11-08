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

    protected $visible = [
        'name', 'quantity', 'unit_price', 'totalPrice'
    ];

    protected $appends = [
        'name', 'unit_price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'totalPrice' => 'float(8,2)'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getNameAttribute()
    {
        return $this->product->name;
    }

    public function getUnitPriceAttribute()
    {
        return $this->product->price;
    }
}
