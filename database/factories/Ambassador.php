<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\People\Ambassador;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(Ambassador::class, function (Faker $faker) {
    return [
        'name'          => new Translation(['en' => $faker->name, 'zh' => $faker->name]),
        'slug'          => \Illuminate\Support\Str::random(4),
        'about'         => new Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
        'achievements'  => new Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
        'collaboration' => new Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
        'philosophy'    => new Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
        'is_public'     => $faker->boolean
    ];
});

$factory->state(Ambassador::class, 'private', [
    'is_public' => false
]);

$factory->state(Ambassador::class, 'public', [
    'is_public' => true
]);
