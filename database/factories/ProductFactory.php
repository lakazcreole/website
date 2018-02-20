<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->word),
        'price' => $faker->randomNumber(2)
    ];
});
