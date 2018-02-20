<?php

namespace App\Http\Controllers;

use App\Order;
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
        return view('orders.accepted');
    }

    public function getDeclineForm(Order $order)
    {
        return view('orders.decline_form');
    }

    public function decline(Order $order, DeclineOrder $request)
    {
        $order->decline($request->input('message'));
        return view('orders.declined');
    }
}
