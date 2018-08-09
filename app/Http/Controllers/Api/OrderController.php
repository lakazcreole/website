<?php

namespace App\Http\Controllers\Api;

use Carbon;
use App\Order;
use App\Product;
use App\Customer;
use App\PromoCode;
use App\Http\Requests\StoreOrder;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOrder  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        $customer = Customer::updateOrCreate([
            'email' => $request->customer['email']
        ], [
            'firstName' => $request->customer['firstName'],
            'lastName' => $request->customer['lastName'],
            'phone' => $request->customer['phone'],
        ]);
        $order = Order::create([
            'address1' => $request->address['address1'],
            'address2' => $request->address['address2'],
            'address3' => $request->address['address3'],
            'city' => $request->address['city'],
            'zip' => $request->address['zip'],
            'date' => Carbon\Carbon::createFromFormat('d/m/Y', $request->date),
            'time' => $request->time,
            'customer_id' => $customer->id,
        ]);
        foreach ($request->orderLines as $line)
        {
            $product = Product::find($line['id']);
            $order->addProduct($product, $line['quantity']);
        }
        if ($request->has('promoCode'))
        {
            $promoCode = PromoCode::findByName($request->promoCode);
            $order->applyPromoCode($promoCode);
        }
        return new OrderResource($order);
    }
}
