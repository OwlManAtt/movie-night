<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Media::class, function (Faker $faker) {
    $type = $faker->randomElement([
        App\Models\Movie::class,
        App\Models\Series::class,
    ]);
    $media_morph = factory($type)->create();

    return [
        'title' => $faker->movieTitle,
        'imdb_id' => $faker->imdbId,
        'imdb_last_synced_at' => null,
        'imdb_rating' => null,
        'year_released' => null,
        'runtime' => null,
        'poster_url' => null,
        'content_type' => $type,
        'content_id' => $media_morph->id,
        'created_at' => $faker->dateTimeThisYear(),
        'updated_at' => $faker->dateTimeThisYear(),
        'deleted_at' => null,
    ];
});

$factory->state(App\Models\Media::class, 'imdb-data', function ($faker) {
    return [
        'imdb_last_synced_at' => $faker->dateTimeThisMonth(),
        'imdb_rating' => $faker->numberBetween(1, 5),
        'year_released' => $faker->year(),
        'poster_url' => $faker->imageUrl(400, 600, 'cats'),
        'runtime' => vsprintf('%s minutes', [$faker->biasedNumberBetween(150, 212)]),
    ];
});
