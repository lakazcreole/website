<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function __invoke()
    {
        return view('home')->with([
            'orderUrl' => route('order')
        ]);
    }
}
