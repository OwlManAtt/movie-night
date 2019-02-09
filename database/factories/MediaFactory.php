<?php

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Relations\Relation;

$factory->define(App\Models\Media::class, function (Faker $faker) {
    return [
        // 'content_type' => 'movie, series, or episode',
        // 'content_id' => xxx,

        'title' => $faker->movieTitle,
        'imdb_id' => $faker->imdbId,
        'imdb_last_synced_at' => null,
        'imdb_rating' => null,
        'year_released' => null,
        'runtime' => null,
        'poster_url' => null,
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

$factory->state(App\Models\Media::class, 'movie', function ($faker) {
    $content = factory(App\Models\Movie::class)->create();

    return [
        'content_type' => 'movie',
        'content_id' => $content->id,
    ];
});

$factory->state(App\Models\Media::class, 'series', function ($faker) {
    $content = factory(App\Models\Series::class)->create();

    return [
        'content_type' => 'series',
        'content_id' => $content->id,
    ];
});

$factory->state(App\Models\Media::class, 'episode', function ($faker) {
    $content = factory(App\Models\Episode::class)->create();

    return [
        'content_type' => 'episode',
        'content_id' => $content->id,
    ];
});
