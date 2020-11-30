<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\People\Coach;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(Coach::class, function (Faker $faker) {
    return [
        'name'           => new Translation(['en' => $faker->name, 'zh' => $faker->name]),
        'slug'           => \Illuminate\Support\Str::random(4),
        'location'       => new Translation(['en' => $faker->city, 'zh' => $faker->city]),
        'certifications' => new Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
        'experience'     => new Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
        'philosophy'     => new Translation(['en' => $faker->paragraph, 'zh' => $faker->paragraph]),
        'email'          => $faker->email,
        'phone'          => $faker->phoneNumber,
        'website'        => $faker->url,
        'line'           => 'test_line_id',
        'is_public'      => $faker->boolean,
    ];
});

$factory->state(Coach::class, 'private', [
    'is_public' => false,
]);

$factory->state(Coach::class, 'public', [
    'is_public' => true,
]);
