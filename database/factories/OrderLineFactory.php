<?php

use Faker\Generator as Faker;

$factory->define(App\OrderLine::class, function (Faker $faker) {
    return [
        'quantity' => $faker->randomNumber(2),
    ];
});
