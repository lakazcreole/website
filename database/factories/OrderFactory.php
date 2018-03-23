<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'address1' => $faker->streetAddress,
        'address2' => $faker->secondaryAddress ,
        'address3' => $faker->sentence(3),
        'city' => $faker->city,
        'zip' => $faker->postCode,
        'date' => $faker->date(),
        'time' => $faker->time(),
    ];
});
