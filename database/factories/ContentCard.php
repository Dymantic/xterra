<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Media\ContentCard;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(ContentCard::class, function (Faker $faker) {
    return [
        'category' => new Translation(['en' => $faker->word, 'zh' => $faker->word]),
        'title'    => new Translation(['en' => $faker->sentence, 'zh' => $faker->sentence]),
        'link'     => $faker->url
    ];
});
