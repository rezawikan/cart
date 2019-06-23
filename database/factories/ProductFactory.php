<?php

use Faker\Generator as Faker;
use App\Models\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'slug' => str_slug($name),
        'description' => $faker->sentence(5),
        'base_price'  => 900,
        'price'       => 1000,
        'weight'      => 500
    ];
});
