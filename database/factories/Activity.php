<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Occasions\Activity;
use App\Occasions\Event;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class),
        'name'        => [
            'en' => $faker->words(3, true),
            'zh' => $faker->words(3, true),
        ],
        'distance'    => [
            'en' => $faker->numberBetween(5, 41) . 'km',
            'zh' => $faker->numberBetween(5, 41) . '公里',
        ],
        'description' => new \App\Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
        'category'    => $faker->randomElement(Activity::ACTIVITY_TYPES),
        'is_race'     => $faker->boolean,
    ];
});

$factory->state(Activity::class, 'race', [
    'is_race' => true,
]);

$factory->state(Activity::class, 'activity', [
    'is_race' => false,
]);
