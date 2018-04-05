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
Route::get('/', 'WebsiteController')->name('home');
Route::get('/commande', 'OrderController@create')->name('order');

// Authentication
Auth::routes();

// Dashboard
Route::prefix('/dashboard')->middleware('can:access-dashboard')->group(function () {
    Route::get('/', 'DashboardController')->name('dashboard');

    //Orders
    Route::get('/orders/{order}/accept', 'OrderController@accept')->middleware('can:accept,order');
    Route::get('/orders/{order}/decline', 'OrderController@getDeclineForm')->middleware('can:decline,order');
    Route::post('/orders/{order}/decline', 'OrderController@decline')->middleware('can:decline,order');
});


// Local development
if (App::environment('local')) {
    Route::get('/mailables/OrderAccepted', function() {
        $order = factory(App\Order::class)->create([
            'customer_id' => factory(App\Customer::class)->create()->id
        ]);
        $product = factory(App\Product::class)->create();
        $order->lines()->save(App\OrderLine::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'totalPrice' => 2 * $product->price,
        ]));
        return new App\Mail\OrderAccepted($order);
    });
}
