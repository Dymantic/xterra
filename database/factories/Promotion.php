<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Shop\Promotion;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(Promotion::class, function (Faker $faker) {
    return [
        'title'       => new Translation([
            'en' => $faker->words(3, true),
            'zh' => $faker->words(3, true)
        ]),
        'writeup'     => new Translation([
            'en' => $faker->paragraph,
            'zh' => $faker->paragraph
        ]),
        'button_text' => new Translation([
            'en' => $faker->words(2, true),
            'zh' => $faker->words(2, true)
        ]),
        'link'        => $faker->url,
        'is_public' => $faker->boolean,
        'is_featured' => $faker->boolean,
    ];
});

$factory->state(Promotion::class, 'private', [
    'is_public' => false,
]);

$factory->state(Promotion::class, 'public', [
    'is_public' => true,
]);

$factory->state(Promotion::class, 'featured', [
    'is_featured' => true,
    'is_public' => true,
]);

$factory->state(Promotion::class, 'un-featured', [
    'is_featured' => false,
]);
