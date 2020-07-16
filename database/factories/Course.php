<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Occasions\Course;
use App\Occasions\Event;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class),
        'name'     => ['en' => $faker->words(3, true), 'zh' => $faker->words(3, true)],
        'distance'     => [
            'en' => $faker->numberBetween(5, 42) . "km",
            'zh' => $faker->numberBetween(5, 42) . '公里'
        ],
        'description' => ['en' => $faker->paragraph, 'zh' => $faker->paragraph],
    ];
});
