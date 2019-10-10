<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Blog\Comment::class, function (Faker $faker) {
    return [
        'translation_id' => function() { return factory(\App\Blog\Translation::class)->create()->id; },
        'author' => $faker->name,
        'fb_id' => '123456789',
        'body' => $faker->paragraph,
    ];
});
