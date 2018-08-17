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

    Route::name('dashboard.')->group(function() {
        // Logs
        Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs');

        // Orders
        Route::get('/orders', 'OrderController@index')->name('orders.index');
        Route::get('/orders/{order}/accept', 'OrderController@getAcceptForm')->middleware('can:accept,order')->name('orders.accept');
        Route::post('/orders/{order}/accept', 'OrderController@accept')->middleware('can:accept,order');
        Route::get('/orders/{order}/decline', 'OrderController@getDeclineForm')->middleware('can:decline,order')->name('orders.decline');
        Route::post('/orders/{order}/decline', 'OrderController@decline')->middleware('can:decline,order');
        Route::post('/orders/{order}/cancel', 'OrderController@cancel')->middleware('can:cancel,order')->name('orders.cancel');

        // Products
        Route::get('/products', 'ProductController@index')->name('products.index');
        Route::get('/products/create', 'ProductController@create')->name('products.create');
        Route::post('/products/create', 'ProductController@store')->name('products.store');
        Route::get('/products/{product}/edit', 'ProductController@edit')->name('products.edit');
        Route::post('/products/{product}/edit', 'ProductController@update')->name('products.update');

        // Offers
        Route::get('/offers', 'OfferController@index')->name('offers.index');
        Route::get('/offers/create', 'OfferController@create')->name('offers.create');
        Route::post('/offers/create', 'OfferController@store')->name('offers.store');
        Route::get('/offers/{offer}/edit', 'OfferController@edit')->name('offers.edit');
        Route::post('/offers/{offer}/edit', 'OfferController@update')->name('offers.update');
        Route::get('/offers/{offer}/destroy', 'OfferController@destroy')->name('offers.destroy');

        // Discounts
        Route::resource('discounts', 'DiscountController')->except(['show']);
    });
});


// Local development
if (App::environment('local')) {
    Route::get('/mailables/NewOrder', function() {
        $order = factory(App\Order::class)->create([
            'customer_id' => factory(App\Customer::class)->create()->id
        ]);
        $product = App\Product::find(1);
        $order->applyPromoCode(factory(App\PromoCode::class)->create(['discount_id' => factory(App\Discount::class)->create()->id]));
        $order->lines()->save(App\OrderLine::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'totalPrice' => 2 * $product->price,
        ]));
        return new App\Mail\NewOrder($order);
    });
    Route::get('/mailables/OrderAccepted', function() {
        $order = factory(App\Order::class)->create([
            'customer_id' => factory(App\Customer::class)->create()->id,
            'information' => 'MI MANGE PAS PIMENT GARS'
        ]);
        $product = App\Product::find(1);
        $order->applyPromoCode(factory(App\PromoCode::class)->create(['discount_id' => factory(App\Discount::class)->create()->id]));
        $order->lines()->save(App\OrderLine::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'totalPrice' => 2 * $product->price,
        ]));
        return new App\Mail\OrderAccepted($order);
    });
}
