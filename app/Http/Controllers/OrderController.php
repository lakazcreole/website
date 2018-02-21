<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\DeclineOrder;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create');
    }

    public function accept(Order $order)
    {
        $order->accept();
        return view('orders.accepted')->with([
            'id' => $order->id,
            'customerName' => $order->customer->firstName,
            'customerEmail' => $order->customer->email,
            'customerPhone' => $order->customer->phone,
            'lines' => $order->lines,
            'address' => $order->address,
            'date' => $order->date,
            'time' => $order->time,
            'totalPrice' => $order->totalPrice,
        ]);
    }

    public function getDeclineForm(Order $order)
    {
        return view('orders.decline_form')->with([
            'id' => $order->id,
            'customerName' => $order->customer->firstName,
            'customerEmail' => $order->customer->email,
            'customerPhone' => $order->customer->phone,
            'lines' => $order->lines,
            'address' => $order->address,
            'date' => $order->date,
            'time' => $order->time,
            'totalPrice' => $order->totalPrice,
            'postUrl' => action('OrderController@decline', [$order->id]),
        ]);
    }

    public function decline(Order $order, DeclineOrder $request)
    {
        $order->decline(nl2br($request->input('message')));
        return view('orders.declined')->with([
            'id' => $order->id,
            'customerName' => $order->customer->firstName,
            'customerEmail' => $order->customer->email,
            'customerPhone' => $order->customer->phone,
            'lines' => $order->lines,
            'address' => $order->address,
            'date' => $order->date,
            'time' => $order->time,
            'totalPrice' => $order->totalPrice,
            'declineMessage' => $order->declineMessage,
        ]);
    }
}
