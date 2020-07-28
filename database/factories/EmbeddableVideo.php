<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media\EmbeddableVideo;
use App\Occasions\Event;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(EmbeddableVideo::class, function (Faker $faker) {
    return [
        'videoed_id' => 1,
        'videoed_type' => Event::class,
        'platform' => $faker->word,
        'video_id' => Str::random(10),
        'title' => new \App\Translation(['en' => $faker->sentence, 'zh' => $faker->sentence]),
    ];
});

$factory->state(EmbeddableVideo::class, 'youtube', [
    'platform' => EmbeddableVideo::YOUTUBE,
]);
