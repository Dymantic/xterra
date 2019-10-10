<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Blog\Tag::class, function (Faker $faker) {
    return [
        'tag_name' => $faker->words(2, true)
    ];
});
