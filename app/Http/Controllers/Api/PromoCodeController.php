<?php

namespace App\Http\Controllers\Api;

use App\PromoCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PromoCodeController extends Controller
{
    public function validateName($name)
    {
        $promo = PromoCode::findByName($name);
        if ($promo)
        {
            return $promo->toJson();
        }
        return response()->json([
            'is_valid' => false
        ]);
    }
}
