<?php

namespace App;

use App\Discount;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = ['name', 'discount_id', 'uses', 'max_uses', 'begin_at', 'end_at'];

    protected $visible = ['discount_id', 'is_valid'];

    protected $appends = ['is_valid'];

    protected $casts = [
        'discount_id' => 'integer'
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
