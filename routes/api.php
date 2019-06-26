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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::resource('categories', 'Categories\CategoryController');
Route::resource('products', 'Products\ProductController');
Route::resource('product-type', 'ProductType\ProductTypeController');
Route::resource('variations','Products\ProductVariationController');
Route::resource('addresses', 'Addresses\AddressController');
Route::resource('public-addresses', 'Addresses\PublicAddressesController');
Route::resource('provinces', 'Location\ProvinceController');
Route::resource('cities', 'Location\CityController');
Route::resource('subdistricts', 'Location\SubdistrictController');
Route::resource('orders', 'Orders\OrderController');
Route::resource('public-orders', 'Orders\PublicOrderController');
Route::resource('payment-methods', 'PaymentMethods\PaymentMethodController');
Route::resource('images', 'Images\ImageController');
Route::resource('users', 'User\UserController');
Route::resource('post', 'Posts\PostController');

Route::get('analytics', 'Analytics\AnalyticsController@analytics');
Route::get('livestock', 'Stock\LiveStockController');
Route::get('addresses/{address}/shipping', 'Addresses\AddressShippingController@action');
Route::get('shipping', 'Shipping\ShippingController@index');




Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'Auth\RegisterController@action');
    Route::post('login', 'Auth\LoginController@action');
    Route::get('me', 'Auth\MeController@action');

    // Route::get('{provider}', 'Auth\LoginController@redirectToProvider');
    // Route::get('{provider}/callback', 'Auth\LoginController@handleProviderCallback');
});

Route::resource('cart','Cart\CartController', [
  'parameters' => [
    'cart' => 'ProductVariation'
  ]
]);
Route::resource('public-cart','Cart\PublicCartController', [
  'parameters' => [
    'public-cart' => 'ProductVariation'
  ]
]);
