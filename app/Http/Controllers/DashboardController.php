<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard.home')
            ->with('orders', Order::with(['customer', 'lines.product'])->get());
    }
}
