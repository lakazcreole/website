<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
