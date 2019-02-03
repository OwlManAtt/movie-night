<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Series::class, function (Faker $faker) {
    return [
        'episode_count' => $faker->biasedNumberBetween(2, 13),
        'created_at' => $faker->dateTimeThisYear(),
        'updated_at' => $faker->dateTimeThisYear(),
        'deleted_at' => null,
    ];
});

$factory->afterCreating(App\Models\Series::class, function ($series, $faker) {
    factory(App\Models\SeriesEpisode::class, $series->episode_count)->create(['series_id' => $series->id]);
});
