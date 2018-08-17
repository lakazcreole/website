<?php

use Faker\Generator as Faker;

$factory->define(App\Discount::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->catchPhrase,
        'description' => $faker->sentence
    ];
});
