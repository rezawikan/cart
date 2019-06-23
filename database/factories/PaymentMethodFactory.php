<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\PaymentMethod;
use Faker\Generator as Faker;

$factory->define(PaymentMethod::class, function (Faker $faker) {
    return [
      'type' => 'Bank Transfer'
    ];
});
