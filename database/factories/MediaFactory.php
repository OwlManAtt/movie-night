<?php

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Relations\Relation;

$factory->define(App\Models\Media::class, function (Faker $faker) {
    $type = $faker->randomElement([
        'movie',
        'series',
    ]);

    $morph_map = Relation::morphMap();
    $media_morph = factory($morph_map[$type])->create();

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
        'plot_summary' => $faker->paragraph,
    ];
});
