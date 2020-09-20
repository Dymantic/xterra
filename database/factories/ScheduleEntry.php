<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Occasions\Event;
use App\Occasions\ScheduleEntry;
use Faker\Generator as Faker;

$factory->define(ScheduleEntry::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class),
        'day_of_event' => 1,
        'time_of_day' => ['en' => '6am', 'zh' => '6am'],
        'item' => ['en'=> 'item en', 'zh' => 'item zh'],
        'position' => $faker->numberBetween(1,10),
    ];
});
