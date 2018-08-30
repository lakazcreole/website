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
        return view('products.index', [
            'productTypes' => Product::TYPES,
            'products' => Product::orderBy('name')->get(),
            'createRoute' => 'dashboard.products.create',
            'editRoute' => 'dashboard.products.edit',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create', [
            'productTypes' => Product::TYPES,
            'indexRoute' => 'dashboard.products.index',
            'storeRoute' => 'dashboard.products.store',
        ]);
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
        Log::notice("Product (#{$product->id}) created: {$product->name}");
        return redirect()->route('dashboard.products.index')
            ->with('success', "Le produit {$product->name} a été créé.");
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
            'productTypes' => Product::TYPES,
            'indexRoute' => 'dashboard.products.index',
            'updateRoute' => 'dashboard.products.update',
            'routeParameter' => 'products'
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
        Log::notice("Product #{$product->id} updated");
        return redirect()->route('dashboard.products.index')
            ->with('success', "Le produit {$product->name} a été modifié.");
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
