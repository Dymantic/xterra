<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Blog\Category::class, function (Faker $faker) {
    return [
        'title' => [
            'en' => $faker->words(3, true),
            'zh' => $faker->words(3, true),
        ],
        'description' => [
            'en' => $faker->paragraph,
            'zh' => $faker->paragraph,
        ],
    ];
});
