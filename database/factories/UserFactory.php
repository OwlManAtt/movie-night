<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'nickname' => $faker->unique()->discordNickname(),
        'email' => $faker->optional(0.9)->freeEmail(),
        'avatar_url' => $faker->discordAvatar(),
        'discord_id' => $faker->randomNumber(8),
        'mfa_enabled' => $faker->boolean(),
        'app_access_enabled' => true,
        'remember_token' => str_random(10),
        'created_at' => $faker->dateTimeThisYear(),
        'updated_at' => $faker->dateTimeThisYear(),
    ];
});
