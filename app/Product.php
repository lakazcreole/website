<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'disabled' => 'boolean',
    ];

    public function isStarter()
    {
        return $this->type === 'starter';
    }

    public function isMain()
    {
        return $this->type === 'main';
    }

    public function isDrink()
    {
        return $this->type === 'drink';
    }

    public function isSide()
    {
        return $this->type === 'side';
    }
}
