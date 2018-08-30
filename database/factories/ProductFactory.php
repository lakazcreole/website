<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->unique()->word),
        'type' => $faker->randomElement(['starter', 'main', 'drink', 'side']),
        'pieces' => $faker->randomNumber(1),
        'price' => faker->randomFloat(2, 1, 20),
    ];
});
