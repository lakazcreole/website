<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Offer::class, function (Faker $faker) {
    $startingDate = now();
    $endingDate = $faker->dateTimeBetween($startingDate, '+1 week');
    return [
        'start_at' => $startingDate,
        'end_at' => $endingDate,
        'imageUrl' => '/images/bouchons.jpg'
    ];
});
