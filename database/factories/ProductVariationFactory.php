<?php

use Faker\Generator as Faker;
use App\Models\ProductVariationType;
use App\Models\ProductVariation;
use App\Models\Product;

$factory->define(ProductVariation::class, function (Faker $faker) {
    return [
      'product_id' => factory(Product::class)->create()->id,
        'name' => $faker->unique()->name,
        'product_variation_type_id' => factory(ProductVariationType::class)->create()->id,
        'weight' => 500
    ];
});
