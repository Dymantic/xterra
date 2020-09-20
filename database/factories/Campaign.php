<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Campaigns\Campaign;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(Campaign::class, function (Faker $faker) {
    return [
        'title' => new Translation(['en' => $faker->sentence, 'zh' => $faker->sentence]),
        'intro' => new Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
        'description' => new Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
    ];
});
