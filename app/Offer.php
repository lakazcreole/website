<?php

namespace App;

use App\Product;
use Illuminate\Http\UploadedFile;
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

    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function saveImage(UploadedFile $image)
    {
        $path = $image->store('public/offers');
        $this->imageUrl = str_replace('public', 'storage', $path);
        $this->save();
    }
}
