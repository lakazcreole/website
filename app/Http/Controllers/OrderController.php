<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\AcceptOrder;
use App\Http\Requests\CancelOrder;
use App\Http\Requests\DeclineOrder;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function create()
    {
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
        return view('orders.accept_form', [
            'id' => $order->id,
            'customerFirstName' => $order->customer->firstName,
            'customerLastName' => $order->customer->lastName,
            'customerEmail' => $order->customer->email,
            'customerPhone' => $order->customer->phone,
            'lines' => $order->lines,
            'address1' => $order->address1,
            'address2' => $order->address2,
            'address3' => $order->address3,
            'zip' => $order->zip,
            'city' => $order->city,
            'date' => strftime('%A %d %B %Y', strtotime($order->date)),
            'time' => date('H:i', strtotime($order->time)),
            'totalProductsPrice' => $order->totalProductsPrice,
            'deliveryPrice' => $order->deliveryPrice,
            'finalPrice' => $order->finalPrice,
            'discountName' => $order->promoCode ? $order->promoCode->discount->name : null,
            'discountDescription' => $order->promoCode ? $order->promoCode->discount->description : null,
            'postUrl' => action('OrderController@accept', [$order->id]),
            'declineUrl' => action('OrderController@decline', [$order->id]),
        ]);
    }

    public function accept(Order $order, AcceptOrder $request)
    {
        $order->notifyAccept = $request->input('notify');
        $order->accept(nl2br($request->input('message')));
        Log::notice("Order #{$order->id}) accepted (notify: " . ($order->notifyAccept ? 'true' : 'false') . ")");
        return redirect()->route('dashboard.orders.index')
            ->with('success', "La commande #{$order->id} a été acceptée.");
    }

    public function getDeclineForm(Order $order)
    {
        return view('orders.decline_form')->with([
            'id' => $order->id,
            'customerFirstName' => $order->customer->firstName,
            'customerLastName' => $order->customer->lastName,
            'customerEmail' => $order->customer->email,
            'customerPhone' => $order->customer->phone,
            'lines' => $order->lines,
            'address1' => $order->address1,
            'address2' => $order->address2,
            'address3' => $order->address3,
            'zip' => $order->zip,
            'city' => $order->city,
            'date' => strftime('%A %d %B %Y', strtotime($order->date)),
            'time' => date('H:i', strtotime($order->time)),
            'totalProductsPrice' => $order->totalProductsPrice,
            'deliveryPrice' => $order->deliveryPrice,
            'finalPrice' => $order->finalPrice,
            'postUrl' => action('OrderController@decline', [$order->id]),
            'acceptUrl' => action('OrderController@accept', [$order->id]),
            'discountName' => $order->promoCode ? $order->promoCode->discount->name : null,
            'discountDescription' => $order->promoCode ? $order->promoCode->discount->description : null,
        ]);
    }

    public function decline(Order $order, DeclineOrder $request)
    {
        $order->notifyDecline = $request->input('notify');
        $order->decline(nl2br($request->input('message')));
        Log::notice("Order #{$order->id}) declined (notify: " . ($order->notifyDecline ? 'true' : 'false') . ")");
        return redirect()->route('dashboard.orders.index')
            ->with('success', "La commande #{$order->id} a été refusée.");
    }

    public function cancel(Order $order, CancelOrder $request)
    {
        $order->cancel();
        Log::notice("Order #{$order->id}) canceled");
        return redirect()->route('dashboard.orders.index')
            ->with('success', "La commande #{$order->id} a été annulée.");
    }
}
