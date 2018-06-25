<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProduct;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateProduct;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index')
            ->with('productTypes', Product::TYPES)
            ->with('products', Product::orderBy('name')->get())
            ->with('apiToken', Auth::user()->api_token);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create')
            ->with('productTypes', Product::TYPES);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProduct  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        $product = Product::create($request->only(['name', 'type', 'pieces', 'description', 'price', 'disabled']));
        Log::notice("{$product->name} was added to the products list");
        return view('products.index')
            ->with('productTypes', Product::TYPES)
            ->with('products', Product::all())
            ->with('apiToken', Auth::user()->api_token)
            ->with('success', "Le produit {$product->name} a été créé avec succès !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', [
            'id' => $product->id,
            'name' => $product->name,
            'type' => $product->type,
            'pieces' => $product->pieces,
            'description' => $product->description,
            'price' => $product->price,
            'disabled' => $product->disabled,
            'productTypes' => Product::TYPES
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProduct  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduct $request, Product $product)
    {
        $product->fill($request->only(['name', 'type', 'pieces', 'description', 'price', 'disabled']));
        $product->save();
        Log::notice("Product #{$product->id} was updated");
        return view('products.index')
            ->with('productTypes', Product::TYPES)
            ->with('products', Product::all())
            ->with('apiToken', Auth::user()->api_token)
            ->with('success', "Le produit #{$product->id} ({$product->name}) a été modifié avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
