<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Province;
use Faker\Generator as Faker;

$factory->define(Province::class, function (Faker $faker) {
    return [
        'name' => $faker->country
    ];
});
