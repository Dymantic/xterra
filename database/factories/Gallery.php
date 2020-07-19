<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media\Gallery;
use Faker\Generator as Faker;

$factory->define(Gallery::class, function (Faker $faker) {
    return [
        'title' => ['en' => $faker->sentence, 'zh' => $faker->sentence],
        'description' => ['en' => $faker->paragraph, 'zh' => $faker->paragraph],
    ];
});
