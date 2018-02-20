<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Website
Route::get('/', 'FrontEndController@index')->name('home');
Route::get('/commande', 'OrderController@create');

// Authentication
Auth::routes();

// Dashboard
Route::prefix('/dashboard')->group(function () {
    Route::get('/', 'FrontEndController@dashboard')->name('dashboard');

    //Orders
    Route::get('/orders/{order}/accept', 'OrderController@accept')->middleware('can:accept,order');
    Route::get('/orders/{order}/decline', 'OrderController@getDeclineForm')->middleware('can:decline,order');
    Route::post('/orders/{order}/decline', 'OrderController@decline')->middleware('can:decline,order');
});


// Local development
if (App::environment('local')) {
    Route::get('/mailables/NewOrder', function() {
        $order = factory(App\Order::class)->create([
            'customer_id' => factory(App\Customer::class)->create()->id
        ]);
        $order->lines()->save(App\OrderLine::create([
            'order_id' => $order->id,
            'product_id' => factory(App\Product::class)->create()->id,
            'quantity' => 2,
            'totalPrice' => 69,
        ]));
        return new App\Mail\NewOrder($order);
    });
}
