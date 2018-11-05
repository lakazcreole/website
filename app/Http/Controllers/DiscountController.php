<?php

namespace App\Http\Controllers;

use App\Product;
use App\Discount;
use App\DiscountItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        return view('discounts.index', [
            'discounts' => Discount::with('items')->get(),
            'createRoute' => 'dashboard.discounts.create',
            'editRoute' => 'dashboard.discounts.edit',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discounts.create', [
            'products' => Product::all(),
            'productTypes' => Product::TYPES,
            'indexRoute' => 'dashboard.discounts.index',
            'storeRoute' => 'dashboard.discounts.store',
        ]);
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
        foreach ($request->items as $item) {
            $discountItem = DiscountItem::create([
                'discount_id' => $discount->id,
                'percent' => $item['percent'],
                'required' => $item['required']
            ]);
            foreach ($item['products'] as $productId) {
                $discountItem->products()->attach($productId);
            }
        }
        Log::notice("Discount (#{$discount->id}) created: {$request->name}");
        return redirect()->route('dashboard.discounts.index')
            ->with('success', "La réduction {$request->name} a été créée.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        $discount->loadMissing('items.products');
        return view('discounts.edit', [
                'id' => $discount->id,
                'name' => $discount->name,
                'description' => $discount->description,
                'discountItems' => $discount->items,
                'products' =>  Product::all(),
                'productTypes' => Product::TYPES,
                'indexRoute' => 'dashboard.discounts.index',
                'updateRoute' => 'dashboard.discounts.update',
                'destroyRoute' => 'dashboard.discounts.destroy',
                'routeParameter' => 'discount'
            ]);
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
        $discount->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        foreach ($discount->items as $item) {
            $item->products()->detach();
            $item->delete();
        }
        foreach ($request->items as $item) {
            $discountItem = DiscountItem::create([
                'discount_id' => $discount->id,
                'percent' => $item['percent'],
                'required' => $item['required']
            ]);
            foreach ($item['products'] as $productId) {
                $discountItem->products()->attach($productId);
            }
        }
        Log::notice("Discount (#{$discount->id}) updated: {$request->name}");
        return redirect()->route('dashboard.discounts.index')
            ->with('success', "La réduction {$request->name} a été modifiée.");
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
        Log::notice("Discount #{$discount->id} deleted");
        return redirect()->route('dashboard.discounts.index')
            ->with('success', "La réduction {$discount->name} a été supprimée.");
    }
}
