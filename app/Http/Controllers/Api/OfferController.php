<?php

namespace App\Http\Controllers\Api;

use App\Offer;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = now();
        $filter = function($query) {
            $query->where('disabled', false);
        };
        $offers = Offer::whereHas('product', $filter)->with(['product' => $filter])->where('enabled', true)->where('begin_at', '<=', $today)->where('end_at', '>=', $today)->get();
        return ApiResource::collection($offers);
    }
}
