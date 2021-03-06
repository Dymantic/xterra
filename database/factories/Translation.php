<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Blog\Translation::class, function (Faker $faker) {
    return [
        'article_id'  => function () {
            return factory(\App\Blog\Article::class)->create()->id;
        },
        'language'    => $faker->randomElement(['en', 'zh']),
        'title'       => $faker->sentence,
        'intro'       => $faker->paragraph,
        'description' => $faker->paragraph,
        'body'        => $faker->paragraphs(3, true),
        'author_name' => $faker->name,
    ];
});

$factory->state(\App\Blog\Translation::class, 'unpublished',  function (Faker $faker) {
    return [
        'article_id'  => function () {
            return factory(\App\Blog\Article::class)->create()->id;
        },
        'language'    => $faker->randomElement(['en', 'zh']),
        'title'       => $faker->sentence,
        'intro'       => $faker->paragraph,
        'description' => $faker->paragraph,
        'body'        => $faker->paragraphs(3, true),
        'first_published_on' => null,
        'published_on' => null,
        'is_published' => false,
    ];
});

$factory->state(\App\Blog\Translation::class, 'published',  function (Faker $faker) {
    return [
        'article_id'  => function () {
            return factory(\App\Blog\Article::class)->create()->id;
        },
        'language'    => $faker->randomElement(['en', 'zh']),
        'title'       => $faker->sentence,
        'intro'       => $faker->paragraph,
        'description' => $faker->paragraph,
        'body'        => $faker->paragraphs(3, true),
        'first_published_on' => \Illuminate\Support\Carbon::yesterday(),
        'published_on' => \Illuminate\Support\Carbon::yesterday(),
        'is_published' => true,
    ];
});

$factory->state(\App\Blog\Translation::class, 'en',  function (Faker $faker) {
    return [
        'language' => 'en',
    ];
});

$factory->state(\App\Blog\Translation::class, 'zh',  function (Faker $faker) {
    return [
        'language' => 'zh',
    ];
});

$factory->state(\App\Blog\Translation::class, 'live',  function (Faker $faker) {
    return [
        'first_published_on' => \Illuminate\Support\Carbon::yesterday(),
        'published_on' => \Illuminate\Support\Carbon::yesterday(),
        'is_published' => true,
    ];
});

$factory->state(\App\Blog\Translation::class, 'scheduled',  function (Faker $faker) {
    return [
        'first_published_on' => \Illuminate\Support\Carbon::yesterday(),
        'published_on' => \Illuminate\Support\Carbon::tomorrow()->addDays(5),
        'is_published' => true,
    ];
});

$factory->state(\App\Blog\Translation::class, 'draft',  function (Faker $faker) {
    return [
        'first_published_on' => \Illuminate\Support\Carbon::yesterday(),
        'published_on' => \Illuminate\Support\Carbon::tomorrow()->addDays(5),
        'is_published' => false,
    ];
});

$factory->state(\App\Blog\Translation::class, 'new_en', [
        'language'    => 'en',
        'intro'       => null,
        'description' => null,
        'body'        => null,
    ]
);

$factory->state(\App\Blog\Translation::class, 'new_zh', [
        'language'    => 'zh',
        'intro'       => null,
        'description' => null,
        'body'        => null,
    ]
);
