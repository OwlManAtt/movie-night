<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Movie::class, function (Faker $faker) {
    return [
        'created_at' => $faker->dateTimeThisYear(),
        'updated_at' => $faker->dateTimeThisYear(),
        'deleted_at' => null,
    ];
});
