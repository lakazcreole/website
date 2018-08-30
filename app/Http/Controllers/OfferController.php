<?php

namespace App\Http\Controllers;

use App\Offer;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\StoreOffer;
use App\Http\Requests\UpdateOffer;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('offers.index', [
                'offers' => Offer::all(),
                'createRoute' => 'dashboard.offers.create',
                'editRoute' => 'dashboard.offers.edit',
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offers.create', [
                'products' => Product::all(),
                'productTypes' => Product::TYPES,
                'indexRoute' => 'dashboard.offers.index',
                'storeRoute' => 'dashboard.offers.store',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOffer  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOffer $request)
    {
        $offer = new Offer();
        $offer->name = $request->name;
        $offer->product_id = $request->product;
        $offer->begin_at = Carbon::createFromFormat('d/m/Y', $request->begin_date)->startOfDay();
        $offer->end_at =  Carbon::createFromFormat('d/m/Y', $request->end_date)->startOfDay();
        $offer->enabled = $request->enabled;
        $offer->saveImage($request->file('image'));
        Log::notice("Offer (#{$offer->id}) created: {$offer->name}");
        return redirect()->route('dashboard.offers.index')
            ->with('success', "L'offre {$request->name} a été créé avec succès !");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        return view('offers.edit', [
            'id' => $offer->id,
            'name' => $offer->name,
            'product' => $offer->product_id,
            'begin_date' => $offer->begin_at,
            'end_date' => $offer->end_at,
            'enabled' => $offer->enabled,
            'imageUrl' => $offer->imageUrl,
            'products' => Product::all(),
            'productTypes' => Product::TYPES,
            'indexRoute' => 'dashboard.offers.index',
            'updateRoute' => 'dashboard.offers.update',
            'destroyRoute' => 'dashboard.offers.destroy',
            'routeParameter' => 'offer'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOffer  $request
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOffer $request, Offer $offer)
    {
        $offer->name = $request->name;
        $offer->product_id = $request->product;
        $offer->begin_at =  Carbon::createFromFormat('d/m/Y', $request->begin_date)->startOfDay();
        $offer->end_at = Carbon::createFromFormat('d/m/Y', $request->end_date)->startOfDay();
        $offer->enabled = $request->enabled;
        if ($request->hasFile('image')) {
            $offer->saveImage($request->file('image'));
        } else {
            $offer->save();
        }
        Log::notice("Offer #{$offer->id} updated");
        return redirect()->route('dashboard.offers.index')
            ->with('success', "L'offre {$request->name} a été modifiée avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        Log::notice("Offer #{$offer->id} deleted");
        return redirect()->route('dashboard.offers.index')
            ->with('success', "L'offre {$offer->name} a été supprimée avec succès !");
    }
}
