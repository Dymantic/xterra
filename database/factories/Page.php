<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pages\Page;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'title'           => new Translation(
            ['en' => $faker->sentence, 'zh' => $faker->sentence],
        ),
        'menu_name'       => new Translation(
            ['en' => $faker->words(3, true), 'zh' => $faker->words(3, true)],
        ),
        'blurb'           => new Translation(
            ['en' => $faker->sentence, 'zh' => $faker->sentence],
        ),
        'description'     => new Translation(
            ['en' => $faker->paragraph, 'zh' => $faker->paragraph],
        ),
        'content'         => new Translation(
            ['en' => $faker->paragraph, 'zh' => $faker->paragraph],
        ),
        'is_public'       => $faker->boolean,
        'first_published' => \Illuminate\Support\Carbon::yesterday(),
    ];
});

$factory->state(Page::class, 'draft', [
    'first_published' => null,
    'is_public'       => false,
]);

$factory->state(Page::class, 'private', [
    'is_public' => false,
]);

$factory->state(Page::class, 'public', [
    'is_public' => true,
]);
