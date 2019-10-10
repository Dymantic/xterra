<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Blog\Reply::class, function (Faker $faker) {
    return [
        'comment_id' => function() { return factory(\App\Blog\Comment::class)->create()->id; },
        'author' => $faker->name,
        'fb_id' => '123456789',
        'body' => $faker->sentence,
    ];
});
