<?php

namespace App;

use App\Product;
use App\PromoCode;
use Illuminate\Data;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['name'];

    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }

    public function promoCodes()
    {
        return $this->hasMany(PromoCode::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['percent', 'required']);
    }

    public function addProduct($productId, $percentage, $required = true)
    {
        $this->products()->attach($productId, [
            'percent' => $percentage,
            'required' => $required
        ]);
    }

    public function addFreeProduct($productId, $required = true)
    {
        $this->addProduct($productId, 100, $required);
    }

    public function getValueAttribute()
    {
        return $this->products->reduce(function($acc, $product) {
            return $acc + $product->price * $product->pivot->percent / 100;
        }, 0);
    }

    public function getRequiredProductsAttribute()
    {
        return $this->products->filter(function($product) {
            return $product->pivot->required;
        });
    }
}
