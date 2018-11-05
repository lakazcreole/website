<?php

use Faker\Generator as Faker;

$factory->define(App\DiscountItem::class, function (Faker $faker) {
    return [
        'percent' => $faker->numberBetween(1, 100),
        'required' => $faker->boolean
    ];
});
