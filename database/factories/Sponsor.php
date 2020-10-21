<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Occasions\Event;
use App\Occasions\Sponsor;
use App\Translation;
use Faker\Generator as Faker;

$factory->define(Sponsor::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class),
        'name'       => new Translation([
            'en' => $faker->company,
            'zh' => $faker->company
        ]),
        'description'     => new Translation([
            'en' => $faker->paragraph,
            'zh' => $faker->paragraph
        ]),
        'link'        => $faker->url,
    ];
});


