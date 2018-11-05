<?php

namespace App\Http\Controllers;

use App\Discount;
use App\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StorePromoCode;
use App\Http\Requests\UpdatePromoCode;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('promo_codes.index', [
            'promoCodes' => PromoCode::all(),
            'createRoute' => 'dashboard.promo-codes.create',
            'editRoute' => 'dashboard.promo-codes.edit'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('promo_codes.create', [
            'discounts' => Discount::all(),
            'indexRoute' => 'dashboard.promo-codes.index',
            'storeRoute' => 'dashboard.promo-codes.store',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePromoCode  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePromoCode $request)
    {
        $code = PromoCode::create([
            'name' => $request->name,
            'uses' => 0,
            'max_uses' => $request->maxUses,
            'discount_id' => $request->discountId,
            'begin_at' => Carbon::createFromFormat('d/m/Y', $request->beginAt)->startOfDay(),
            'end_at' => Carbon::createFromFormat('d/m/Y', $request->endAt)->startOfDay(),
        ]);
        Log::notice("PromoCode (#{$code->id}) created: {$request->name}");
        return redirect()->route('dashboard.promo-codes.index')
            ->with('success', "Le code promotionnel {$request->name} a été créé.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function edit(PromoCode $promoCode)
    {
        return view('promo_codes.edit', [
            'id' => $promoCode->id,
            'name' => $promoCode->name,
            'uses' => $promoCode->uses,
            'maxUses' => $promoCode->max_uses,
            'discountId' => $promoCode->discount_id,
            'beginAt' => $promoCode->begin_at,
            'endAt' => $promoCode->end_at,
            'discounts' =>  Discount::all(),
            'indexRoute' => 'dashboard.promo-codes.index',
            'updateRoute' => 'dashboard.promo-codes.update',
            'destroyRoute' => 'dashboard.promo-codes.destroy',
            'routeParameter' => 'promo-code'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePromoCode  $request
     * @param  \App\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePromoCode $request, PromoCode $promoCode)
    {
        $promoCode->update([
            'name' => $request->name,
            'max_uses' => $request->maxUses,
            'discount_id' => $request->discountId,
            'begin_at' => Carbon::createFromFormat('d/m/Y', $request->beginAt)->startOfDay(),
            'end_at' => Carbon::createFromFormat('d/m/Y', $request->endAt)->startOfDay(),
        ]);
        Log::notice("PromoCode (#{$promoCode->id}) updated: {$request->name}");
        return redirect()->route('dashboard.promo-codes.index')
            ->with('success', "Le code promotionnel {$request->name} a été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
        Log::notice("PromoCode #{$promoCode->id} deleted");
        return redirect()->route('dashboard.promo-codes.index')
            ->with('success', "Le code promotionnel {$promoCode->name} a été supprimé avec succès !");
    }
}
