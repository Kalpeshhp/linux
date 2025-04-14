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

Route::post('/cart-addon-price', 'PackageController@getCartAttributePrice')->name('cart.addon-price');
Route::post('/generate-key', 'APIController@generateKey')->name('generate.key');
Route::get('/generate-id', 'APIController@generateid')->name('generate.id');
Route::get('/get-fabric-filters', 'APIController@getFilterOptions')->name('get.fabric.filters');
Route::post('create-shopify-product', 'APIController@createShopifyProduct');
Route::post('store-subscription', 'SubscriptionController@storeSubscription')->name('store.Subscription');