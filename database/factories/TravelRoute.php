<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Occasions\Event;
use App\Occasions\TravelRoute;
use Faker\Generator as Faker;

$factory->define(TravelRoute::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class),
        'name' => ['en' => $faker->sentence, 'zh' => $faker->sentence],
        'description' => ['en' => $faker->paragraph, 'zh' => $faker->paragraph],
    ];
});
