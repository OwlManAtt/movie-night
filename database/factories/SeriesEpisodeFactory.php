<?php

use Faker\Generator as Faker;

$factory->define(App\Models\SeriesEpisode::class, function (Faker $faker) {
    return [
        // 'series_id' =>
        'created_at' => $faker->dateTimeThisYear(),
        'updated_at' => $faker->dateTimeThisYear(),
        'deleted_at' => null,
    ];
});
