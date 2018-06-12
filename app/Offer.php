<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $dates = [
        'start_at',
        'end_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
