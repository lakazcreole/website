<?php

namespace App;

use App\Product;
use App\PromoCode;
use Illuminate\Data;
use App\DiscountItem;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['name', 'description'];

    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }

    public function promoCodes()
    {
        return $this->hasMany(PromoCode::class);
    }

    public function items()
    {
        return $this->hasMany(DiscountItem::class);
    }

    public function getRequiredItemsAttribute()
    {
        return $this->items->filter(function($item) {
            return $item->required;
        });
    }

    public function getOptionalItemsAttribute()
    {
        return $this->items->filter(function($item) {
            return !$item->required;
        });
    }
}
