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

use App\Models\Returns;
use Carbon\Carbon;
Route::resource('shipping', 'Shipping\ShippingController');
Route::get('/','Stock\LiveStockController');
Route::resource('users', 'User\UserController');
Route::get('addresses/{address}/shipping', 'Addresses\AddressShippingController@action');
Route::resource('products', 'Products\ProductController');
Route::resource('cart','Cart\PublicCartController');
Route::resource('variations','Products\ProductVariationController');
Route::resource('payment-methods', 'PaymentMethods\PaymentMethodController');
// Carbon::now()->endOfWeek()
Route::get('/tes', function(){
  // return Carbon::now()->subYear()->year;
  // return   Carbon::now()->subDays(2);
  // return Carbon::today()->subMonths(12);
  return $return = Returns::find(2)->variation;

  return $return->variation;
  // return is_numeric($a);
  // $variant = ProductVariation::find(1);
  // return $variant->stocks->first();
});

Route::resource('products', 'Products\ProductController');
