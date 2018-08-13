<?php

namespace App\Http\Controllers;

use App\Product;
use App\Discount;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDiscount;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('discounts.index')
            ->with('discounts', Discount::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discounts.create')
            ->with('products', Product::all())
            ->with('productTypes', Product::TYPES);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreDiscount  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiscount $request)
    {
        $discount = Discount::create(['name' => $request->name]);
        foreach ($request->products as $product) {
            $discount->addProduct($product['id'], $product['percent'], $product['required']);
        }
        return redirect()->route('dashboard.discounts.index')
            ->with('success', "La réduction {$request->name} a été créée avec succès !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        //
    }
}
