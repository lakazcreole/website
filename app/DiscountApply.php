<?php

namespace App;

use App\Product;
use App\DiscountItem;
use Illuminate\Database\Eloquent\Model;

class DiscountApply extends Model
{
    protected $fillable = ['order_id', 'discount_item_id', 'product_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'discount_item_id' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function discountItem()
    {
        return $this->belongsTo(DiscountItem::class);
    }
}
