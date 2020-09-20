<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media\Gallery;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(Gallery::class, function (Faker $faker) {
    return [
        'title' => new Translation(['en' => $faker->sentence, 'zh' => $faker->sentence]),
        'description' => new Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
    ];
});
