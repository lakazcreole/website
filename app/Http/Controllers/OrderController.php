<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\AcceptOrder;
use App\Http\Requests\DeclineOrder;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create');
    }

    public function getAcceptForm(Order $order)
    {
        setlocale (LC_TIME, 'fr_FR.utf8', 'fra');
        return view('orders.accept_form')->with([
            'id' => $order->id,
            'customerName' => $order->customer->firstName,
            'customerEmail' => $order->customer->email,
            'customerPhone' => $order->customer->phone,
            'lines' => $order->lines,
            'address' => "{$order->address1} {$order->address2} {$order->address3}",
            'date' => strftime('%A %d %B %Y', strtotime($order->date)),
            'time' => date('H:i', strtotime($order->time)),
            'totalPrice' => $order->totalPrice,
            'postUrl' => action('OrderController@accept', [$order->id]),
        ]);
    }

    public function accept(Order $order, AcceptOrder $request)
    {
        $order->accept(nl2br($request->input('message')));
        return view('orders.accepted')->with([
            'id' => $order->id,
            'customerName' => $order->customer->firstName,
            'customerEmail' => $order->customer->email,
            'customerPhone' => $order->customer->phone,
            'lines' => $order->lines,
            'address' => "{$order->address1} {$order->address2} {$order->address3}",
            'zip' => $order->zip,
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
            'address' => "{$order->address1} {$order->address2} {$order->address3}",
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
            'address' => "{$order->address1} {$order->address2} {$order->address3}",
            'date' => $order->date,
            'time' => $order->time,
            'totalPrice' => $order->totalPrice,
            'declineMessage' => $order->declineMessage,
        ]);
    }
}
