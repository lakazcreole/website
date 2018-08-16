<?php

use Faker\Generator as Faker;

$factory->define(App\PromoCode::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->lexify('???????'),
        'uses' => 0,
        'max_uses' => 1,
        'begin_at' => now()->subDays(7),
        'end_at' => now()->addDays(7),
    ];
});
