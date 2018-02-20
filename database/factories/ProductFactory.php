<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->word),
        'price' => floatval($faker->randomNumber(1)) + $faker->randomFloat(2, 0, 1),
    ];
});
