<?php

use App\Models\Address;
use App\Models\User;
use App\Models\Subdistrict;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address_1' => $faker->streetAddress,
        'default' => true,
        'user_id' => factory(User::class)->create()->id,
        'subdistrict_id' => factory(Subdistrict::class)->create()->id
    ];
});
