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
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

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
        Route::resource('products', 'ProductController')->except(['show', 'destroy']);
        // Offers
        Route::resource('offers', 'OfferController')->except(['show']);
        // Discounts
        Route::resource('discounts', 'DiscountController')->except(['show']);
        // PromoCodes
        Route::resource('promo-codes', 'PromoCodeController')->except(['show']);
        // Subscriptions
        Route::get('/subscriptions', 'SubscriptionController@index')->name('subscriptions.index');
        // Contacts
        Route::get('/contacts', 'ContactController@index')->name('contacts.index');
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
        $order->lines()->save(App\OrderLine::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'totalPrice' => $product->price,
        ]));
        return new App\Mail\OrderAccepted($order);
    });
}
