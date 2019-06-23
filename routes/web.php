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

use App\Models\ProductVariation;

Route::get('/','Stock\LiveStockController');
Route::resource('users', 'User\UserController');
Route::get('addresses/{address}/shipping', 'Addresses\AddressShippingController@action');

Route::resource('cart','Cart\PublicCartController');
Route::resource('variations','Products\ProductVariationController');
Route::resource('payment-methods', 'PaymentMethods\PaymentMethodController');

Route::get('/tes', function(){
  $variant = ProductVariation::find(1);
  return $variant->stocks->first();
});

Route::resource('products', 'Products\ProductController');
