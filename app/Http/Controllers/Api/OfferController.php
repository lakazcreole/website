<?php

namespace App\Http\Controllers\Api;

use App\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::with('product')->where('enabled', true)->where('begin_at', '<=', now())->where('end_at', '>=', now())->get();
        return ApiResource::collection($offers);
    }
}
