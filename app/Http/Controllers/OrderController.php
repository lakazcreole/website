<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\AcceptOrder;
use App\Http\Requests\CancelOrder;
use App\Http\Requests\DeclineOrder;

class OrderController extends Controller
{
    public function create()
    {
        if (app()->environment('production')) // disable orders
        {
            return redirect()->route('home');
        }
        return view('orders.create');
    }

    public function index()
    {
        $orders = Order::with([
            'customer',
            'lines' => function($query) {
                $query->orderBy('product_id');
            },
            'lines.product'
        ])->orderByDesc('date')->get();
        return view('orders.index')
            ->with('orders', $orders);
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
            'address1' => $order->address1,
            'address2' => $order->address2,
            'address3' => $order->address3,
            'zip' => $order->zip,
            'date' => strftime('%A %d %B %Y', strtotime($order->date)),
            'time' => date('H:i', strtotime($order->time)),
            'totalProductsPrice' => $order->totalProductsPrice,
            'deliveryPrice' => $order->deliveryPrice,
            'fullPrice' => $order->fullPrice,
            'postUrl' => action('OrderController@accept', [$order->id]),
        ]);
    }

    public function accept(Order $order, AcceptOrder $request)
    {
        $order->notifyAccept = $request->input('notify');
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
            'totalProductsPrice' => $order->totalProductsPrice,
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
            'totalProductsPrice' => $order->totalProductsPrice,
            'postUrl' => action('OrderController@decline', [$order->id]),
        ]);
    }

    public function decline(Order $order, DeclineOrder $request)
    {
        $order->notifyDecline = $request->input('notify');
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
            'totalProductsPrice' => $order->totalProductsPrice,
            'declineMessage' => $order->declineMessage,
        ]);
    }

    public function cancel(Order $order, CancelOrder $request)
    {
        $order->cancel();
    }
}
