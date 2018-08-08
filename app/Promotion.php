<?php

namespace App;

use App\OrderLine;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public function generateDiscount($orderLines, $deliveryPrice)
    {
        $priceBeforePromotion = $orderLines->sum('totalPrice') + $deliveryPrice;
        $finalPrice = $priceBeforePromotion;
        if ($this->final_percentage)
        {
            $finalPrice -= $priceBeforePromotion * $this->final_percentage/100;
        } else if ($this->final_raw)
        {
            $finalPrice -= $this->final_raw;
        }
        return $priceBeforePromotion - $finalPrice;
    }
}
