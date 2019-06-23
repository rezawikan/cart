<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\ShippingMethod;
use Faker\Generator as Faker;

$factory->define(ShippingMethod::class, function (Faker $faker) {
    return [
      'code' => $faker->currencyCode,
      'type' => 'OKE',
      'courier' => 'JNE',
      'price' => 5000,
      'estimation' => '3 hari'
    ];
});
