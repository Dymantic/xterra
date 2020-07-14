<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Occasions\Accommodation;
use App\Occasions\Event;
use Faker\Generator as Faker;

$factory->define(Accommodation::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class),
        'name' => ['en' => $faker->words(3, true), 'zh' => $faker->words(3, true)],
        'description' => ['en' => $faker->paragraph, 'zh' => $faker->paragraph],
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'link' => $faker->url
    ];
});
