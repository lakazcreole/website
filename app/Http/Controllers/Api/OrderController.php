<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Product;
use App\Customer;
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
            'firstName' => $request->customer['firstName'],
            'lastName' => $request->customer['lastName'],
            'phone' => $request->customer['phone'],
            'email' => $request->customer['email'],
        ]);
        $order = Order::create([
            'address1' => $request->address['address1'],
            'address2' => $request->address['address2'],
            'address3' => $request->address['address3'],
            'city' => $request->address['city'],
            'zip' => $request->address['zip'],
            'date' => $request->date,
            'time' => $request->time,
            'customer_id' => $customer->id,
        ]);
        foreach ($request->orderLines as $line) {
            $product = Product::find($line['productId']);
            $order->addProduct($product, $line['quantity']);
        }
        return new OrderResource($order);
    }
}
