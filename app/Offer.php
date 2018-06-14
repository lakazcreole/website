<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['name', 'product_id', 'begin_at', 'end_at', 'imageUrl', 'enabled'];

    protected $hidden = ['name'];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }
}
