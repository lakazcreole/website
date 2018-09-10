<?php

namespace App;

use App\Product;
use App\DiscountItem;
use Illuminate\Database\Eloquent\Model;

class DiscountApply extends Model
{
    protected $fillable = ['order_id', 'discount_item_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function discountItem()
    {
        return $this->belongsTo(DiscountItem::class);
    }
}
