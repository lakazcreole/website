<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Contact and newsletter
Route::post('/contacts', 'Api\ContactController@store');
Route::post('/subscriptions', 'Api\SubscriptionController@store');

// Order page
Route::get('/products', 'Api\ProductController@index');
Route::get('/products/offers', 'Api\OfferController@index');
Route::post('/orders', 'Api\OrderController@store');
Route::get('/promocodes/validate/{name}', 'Api\PromoCodeController@validateName');
Route::get('/discounts/{discount}', 'Api\DiscountController@show');

// Dashboard
Route::middleware(['auth:api', 'can:access-dashboard'])->group(function () {

    // Products
    Route::put('/products/{product}', 'Api\ProductController@update')->middleware('can:update,product');
});
