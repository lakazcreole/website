<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $orders = Order::with([
            'customer',
            'lines' => function($query) {
                $query->orderBy('product_id');
            },
            'lines.product'
        ])->orderByDesc('date')->get();
        return view('dashboard.home')
            ->with('orders', $orders);
    }
}
