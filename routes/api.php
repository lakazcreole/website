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

Route::post('/contacts', 'Api\ContactController@store');
Route::post('/subscriptions', 'Api\SubscriptionController@store');

Route::get('/products', 'Api\ProductController@index');

Route::post('/orders', 'Api\OrderController@store');
