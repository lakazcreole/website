<?php

namespace App\Http\Controllers;

use App\Product;
use App\Discount;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDiscount;
use App\Http\Requests\UpdateDiscount;

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
        $discount = Discount::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        foreach ($request->products as $product) {
            $discount->addProduct($product['id'], $product['percent'], $product['max_items'],$product['required']);
        }
        return redirect()->route('dashboard.discounts.index')
            ->with('success', "La réduction {$request->name} a été créée avec succès !");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        return view('discounts.edit')
            ->with('id', $discount->id)
            ->with('name', $discount->name)
            ->with('description', $discount->description)
            ->with('discountProducts', $discount->products)
            ->with('products', Product::all())
            ->with('productTypes', Product::TYPES);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateDiscount  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiscount $request, Discount $discount)
    {
        $discount->name = $request->name;
        $discount->description = $request->description;
        $discount->products()->detach();
        foreach ($request->products as $product) {
            $discount->addProduct($product['id'], $product['percent'], $product['max_items'],$product['required']);
        }
        $discount->save();
        return redirect()->route('dashboard.discounts.index')
            ->with('success', "La réduction {$request->name} a été modifiée avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('dashboard.discounts.index')
            ->with('success', "La réduction {$discount->name} a été supprimée avec succès !");
    }
}