<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Address;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
      'user_id' => $user = factory(User::class)->create()->id,
      'status' => 'completed',
      'address_id' => factory(Address::class)->create()->id,
      'shipping_method_id' => factory(ShippingMethod::class)->create()->id,
      'payment_method_id' => factory(PaymentMethod::class)->create()->id,
      'discount' => 300,
      'subtotal' => 500,
      'base_subtotal' => 400,
      'total' => 5000
    ];
});
