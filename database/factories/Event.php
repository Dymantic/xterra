<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Occasions\Event;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'slug' => \Illuminate\Support\Str::uuid()->toString(),
        'name' => ['en' => $faker->words(3, true), 'zh' => $faker->words(3, true)],
        'location' => ['en' => $faker->city, 'zh' => $faker->city],
        'venue_name' => ['en' => $faker->words(3, true), 'zh' => $faker->words(3, true)],
        'venue_address' => ['en' => $faker->address, 'zh' => $faker->address],
        'overview' => new \App\Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
        'venue_maplink' => 'https://test.test/map',
        'start' => Carbon::today()->addMonth()->startOfDay(),
        'end' => Carbon::today()->addMonth()->addDay()->endOfDay(),
        'registration_link' => 'https://test.test/registration',
    ];
});

$factory->state(Event::class, 'empty', [
    'location' => ['en' => '', 'zh' => ''],
    'venue_name' => ['en' => '', 'zh' => ''],
    'venue_address' => ['en' => '', 'zh' => ''],
    'overview' => new \App\Translation(['en' => '', 'zh' => '']),
    'venue_maplink' => null,
    'start' => null,
    'end' => null,
    'registration_link' => null,
]);

$factory->state(Event::class, 'private', [
    'is_public' => false,
]);

$factory->state(Event::class, 'public', [
    'is_public' => true,
]);
