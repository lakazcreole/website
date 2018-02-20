<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'date' => $faker->date(),
        'time' => $faker->time(),
    ];
});
