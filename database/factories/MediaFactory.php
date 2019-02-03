<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Media::class, function (Faker $faker) {
    $type = $faker->randomElement([
        App\Models\Movie::class,
        App\Models\Series::class,
    ]);
    $media_morph = factory($type)->create();

    return [
        'title' => $faker->company,
        'imdb_id' => vsprintf('tt%s', [$faker->randomNumber(5)]),
        'imdb_last_synced_at' => null,
        'imdb_rating' => null,
        'year' => null,
        'runtime' => null,
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
        'year' => $faker->year(),
        'runtime' => vsprintf('%s minutes', [$faker->biasedNumberBetween(150, 212)]),
    ];
});
