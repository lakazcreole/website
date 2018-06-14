<?php

namespace App\Http\Controllers;

use App\Offer;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\StoreOffer;
use App\Http\Requests\UpdateOffer;

class OfferController extends Controller
{
    protected $productTypes = [
        [ 'type' => 'starter', 'title' => 'Entrées' ],
        [ 'type' => 'main', 'title' => 'Plats' ],
        [ 'type' => 'drink', 'title' => 'Boissons' ],
        [ 'type' => 'side', 'title' => 'Accompagnements' ],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('offers.index')->with('offers', Offer::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('offers.create')
            ->with('products', Product::all())
            ->with('productTypes', $this->productTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOffer  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOffer $request)
    {
        Offer::create([
            'name' => $request->name,
            'product_id' => $request->product,
            'begin_at' => Carbon::createFromFormat('d/m/Y', $request->begin_date)->startOfDay(),
            'end_at' =>  Carbon::createFromFormat('d/m/Y', $request->end_date)->startOfDay(),
            'enabled' => $request->enabled,
            'imageUrl' => str_replace('public', '', $request->file('image')->store('public/offers')), // remove the 'public/' in the path
        ]);
        return redirect()->route('dashboard.offers.index')
            ->with('success', "L'offre {$request->name} a été créé avec succès !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        return view('offers.edit')
            ->with('id', $offer->id)
            ->with('name', $offer->name)
            ->with('product', $offer->product_id)
            ->with('begin_date', $offer->begin_at)
            ->with('end_date', $offer->end_at)
            ->with('enabled', $offer->enabled)
            ->with('imageUrl', $offer->imageUrl)
            ->with('products', Product::all())
            ->with('productTypes', $this->productTypes);
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
        if ($request->hasFile('image'))
        {
            $offer->imageUrl = str_replace('public', '', $request->file('image')->store('public/offers')); // remove the 'public/' in the path
        }
        $offer->save();
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
        return redirect()->route('dashboard.offers.index')
            ->with('success', "L'offre {$offer->name} a été supprimée avec succès !");
    }
}
