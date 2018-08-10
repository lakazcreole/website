<?php

namespace App;

use App\Discount;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $visible = ['promotion_id', 'is_valid'];

    protected $appends = ['is_valid'];

    protected $casts = [
        'promotion_id' => 'integer'
    ];

    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function isValid()
    {
        $today = now();
        return ($this->begin_at < $today && $this->end_at > $today && $this->uses < $this->max_uses);
    }

    public function getIsValidAttribute()
    {
        return $this->isValid();
    }
}
