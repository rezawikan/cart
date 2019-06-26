<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\City;
use App\Models\Province;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'province_id' => factory(Province::class)->create()->id,
        'capital' => $faker->city
    ];
});
