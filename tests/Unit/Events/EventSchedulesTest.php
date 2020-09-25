<?php


namespace Tests\Unit\Events;


use App\Occasions\Event;
use App\Occasions\Schedule;
use App\Occasions\ScheduleEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventSchedulesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function set_a_schedule_for_an_event()
    {
        $event = factory(Event::class)->create();
        $schedule = new Schedule([
            [
                'day'     => 1,
                'entries' => [
                    [
                        'time_of_day' => ['en' => '6:30am', 'zh' => '6:30am'],
                        'item'        => ['en' => 'test item one', 'zh' => 'zh test item one'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => ['en' => '8:45', 'zh' => '8:45'],
                        'item'        => ['en' => 'test item two', 'zh' => 'zh test item two'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 2,
                    ],
                    [
                        'time_of_day' => ['en' => '12:00', 'zh' => '12:00'],
                        'item'        => ['en' => 'test item three', 'zh' => 'zh test item three'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 3,
                    ],
                ]
            ],
            [
                'day'     => 2,
                'entries' => [
                    [
                        'time_of_day' => ['en' => '6:30am', 'zh' => '6:30am'],
                        'item'        => ['en' => 'test item one', 'zh' => 'zh test item one'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => ['en' => '8:45', 'zh' => '8:45'],
                        'item'        => ['en' => 'test item two', 'zh' => 'zh test item two'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 3,
                    ],
                    [
                        'time_of_day' => ['en' => '7:00', 'zh' => '7:00'],
                        'item'        => ['en' => 'test item three', 'zh' => 'zh test item three'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 2,
                    ],
                ]
            ]
        ]);

        $event->setSchedule($schedule);

        $this->assertCount(6, $event->scheduleEntries);
        $this->assertCount(3, $event->scheduleEntries()->where('day_of_event', 1)->get());
        $this->assertCount(3, $event->scheduleEntries()->where('day_of_event', 2)->get());

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 1,
            'time_of_day'  => ['en' => '6:30am', 'zh' => '6:30am'],
            'item'         => ['en' => 'test item one', 'zh' => 'zh test item one'],
            'location'     => ['en' => 'test ', 'zh' => 'zh test '],
            'position'     => 1,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 1,
            'time_of_day'  => ['en' => '8:45', 'zh' => '8:45'],
            'item'         => ['en' => 'test item two', 'zh' => 'zh test item two'],
            'location'     => ['en' => 'test ', 'zh' => 'zh test '],
            'position'     => 2,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 1,
            'time_of_day'  => ['en' => '12:00', 'zh' => '12:00'],
            'item'         => ['en' => 'test item three', 'zh' => 'zh test item three'],
            'location'     => ['en' => 'test ', 'zh' => 'zh test '],
            'position'     => 3,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 2,
            'time_of_day'  => ['en' => '6:30am', 'zh' => '6:30am'],
            'item'         => ['en' => 'test item one', 'zh' => 'zh test item one'],
            'location'     => ['en' => 'test ', 'zh' => 'zh test '],
            'position'     => 1,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 2,
            'time_of_day'  => ['en' => '8:45', 'zh' => '8:45'],
            'item'         => ['en' => 'test item two', 'zh' => 'zh test item two'],
            'location'     => ['en' => 'test ', 'zh' => 'zh test '],
            'position'     => 3,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 2,
            'time_of_day'  => ['en' => '7:00', 'zh' => '7:00'],
            'item'         => ['en' => 'test item three', 'zh' => 'zh test item three'],
            'location'     => ['en' => 'test ', 'zh' => 'zh test '],
            'position'     => 2,
        ]);
    }

    /**
     * @test
     */
    public function setting_the_event_schedule_clears_out_previous_entries()
    {
        $event = factory(Event::class)->create();
        $old_schedule = new Schedule([
            [
                'day'     => 1,
                'entries' => [
                    [
                        'time_of_day' => ['en' => '5am', 'zh' => '5am'],
                        'item'        => ['en' => 'old item one', 'zh' => 'zh old item one'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => ['en' => '7am', 'zh' => '7am'],
                        'item'        => ['en' => 'old item two', 'zh' => 'zh old item two'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 2,
                    ]
                ]
            ]
        ]);

        $event->setSchedule($old_schedule);

        $new_schedule = new Schedule([
            [
                'day'     => 1,
                'entries' => [
                    [
                        'time_of_day' => ['en' => '9am', 'zh' => '9am'],
                        'item'        => ['en' => 'new item one', 'zh' => 'zh new item one'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => ['en' => '11am', 'zh' => '11am'],
                        'item'        => ['en' => 'new item two', 'zh' => 'zh new item two'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 2,
                    ]
                ]
            ]
        ]);

        $event->setSchedule($new_schedule);

        $this->assertCount(2, $event->scheduleEntries);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 1,
            'time_of_day'  => ['en' => '9am', 'zh' => '9am'],
            'item'         => ['en' => 'new item one', 'zh' => 'zh new item one'],
            'location'     => ['en' => 'test ', 'zh' => 'zh test '],
            'position'     => 1,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 1,
            'time_of_day'  => ['en' => '11am', 'zh' => '11am'],
            'item'         => ['en' => 'new item two', 'zh' => 'zh new item two'],
            'location'     => ['en' => 'test ', 'zh' => 'zh test '],
            'position'     => 2,
        ]);
    }

    /**
     * @test
     */
    public function can_clear_the_schedule()
    {
        $event = factory(Event::class)->create();

        $schedule = new Schedule([
            [
                'day'     => 1,
                'entries' => [
                    [
                        'time_of_day' => ['en' => '9am', 'zh' => '9am'],
                        'item'        => ['en' => 'new item one', 'zh' => 'zh new item one'],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => ['en' => '11am', 'zh' => '11am'],
                        'item'        => ['en' => 'new item two', 'zh' => 'zh new item two'],
                        'position'    => 2,
                    ]
                ]
            ]
        ]);

        $event->setSchedule($schedule);

        $this->assertCount(2, $event->fresh()->scheduleEntries);

        $event->clearSchedule();

        $this->assertCount(0, $event->fresh()->scheduleEntries);
    }

    /**
     * @test
     */
    public function make_schedule_for_event()
    {
        $event = factory(Event::class)->create();
        factory(ScheduleEntry::class)->create([
            'scheduled_id'   => $event->id,
            'scheduled_type' => Event::class,
            'day_of_event'   => 1,
            'time_of_day'    => ['en' => '6am', 'zh' => '6am'],
            'item'           => ['en' => 'item one', 'zh' => 'zh item one'],
            'location'       => ['en' => 'test ', 'zh' => 'zh test '],
            'position'       => 1,
        ]);
        factory(ScheduleEntry::class)->create([
            'scheduled_id'   => $event->id,
            'scheduled_type' => Event::class,
            'day_of_event'   => 1,
            'time_of_day'    => ['en' => '7am', 'zh' => '7am'],
            'item'           => ['en' => 'item two', 'zh' => 'zh item two'],
            'location'       => ['en' => 'test ', 'zh' => 'zh test '],
            'position'       => 2,
        ]);
        factory(ScheduleEntry::class)->create([
            'scheduled_id'   => $event->id,
            'scheduled_type' => Event::class,
            'day_of_event'   => 1,
            'time_of_day'    => ['en' => '10am', 'zh' => '10am'],
            'item'           => ['en' => 'item three', 'zh' => 'zh item three'],
            'location'       => ['en' => 'test ', 'zh' => 'zh test '],
            'position'       => 2,
        ]);
        factory(ScheduleEntry::class)->create([
            'scheduled_id'   => $event->id,
            'scheduled_type' => Event::class,
            'day_of_event'   => 2,
            'time_of_day'    => ['en' => '6am', 'zh' => '6am'],
            'item'           => ['en' => 'item one', 'zh' => 'zh item one'],
            'location'       => ['en' => 'test ', 'zh' => 'zh test '],
            'position'       => 1,
        ]);
        factory(ScheduleEntry::class)->create([
            'scheduled_id'   => $event->id,
            'scheduled_type' => Event::class,
            'day_of_event'   => 2,
            'time_of_day'    => ['en' => '7am', 'zh' => '7am'],
            'item'           => ['en' => 'item two', 'zh' => 'zh item two'],
            'location'       => ['en' => 'test ', 'zh' => 'zh test '],
            'position'       => 2,
        ]);
        factory(ScheduleEntry::class)->create([
            'scheduled_id'   => $event->id,
            'scheduled_type' => Event::class,
            'day_of_event'   => 2,
            'time_of_day'    => ['en' => '10am', 'zh' => '10am'],
            'item'           => ['en' => 'item three', 'zh' => 'zh item three'],
            'location'       => ['en' => 'test ', 'zh' => 'zh test '],
            'position'       => 2,
        ]);

        $expected = [
            [
                'day'     => 1,
                'entries' => [
                    [
                        'time_of_day' => ['en' => '6am', 'zh' => '6am'],
                        'item'        => ['en' => 'item one', 'zh' => 'zh item one'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => ['en' => '7am', 'zh' => '7am'],
                        'item'        => ['en' => 'item two', 'zh' => 'zh item two'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 2,
                    ],
                    [
                        'time_of_day' => ['en' => '10am', 'zh' => '10am'],
                        'item'        => ['en' => 'item three', 'zh' => 'zh item three'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 2,
                    ]
                ],
            ],
            [
                'day'     => 2,
                'entries' => [
                    [
                        'time_of_day' => ['en' => '6am', 'zh' => '6am'],
                        'item'        => ['en' => 'item one', 'zh' => 'zh item one'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => ['en' => '7am', 'zh' => '7am'],
                        'item'        => ['en' => 'item two', 'zh' => 'zh item two'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 2,
                    ],
                    [
                        'time_of_day' => ['en' => '10am', 'zh' => '10am'],
                        'item'        => ['en' => 'item three', 'zh' => 'zh item three'],
                        'location'    => ['en' => 'test ', 'zh' => 'zh test '],
                        'position'    => 2,
                    ]
                ],
            ]
        ];
        $this->assertEquals($expected, Schedule::forEvent($event)->toArray());
    }

    private function assertEventHasScheduleEntry($event, $entry)
    {
        $this->assertCount(1, $event->scheduleEntries()->where([
            ['day_of_event', $entry['day_of_event']],
            ['time_of_day', json_encode($entry['time_of_day'])],
            ['item', json_encode($entry['item'])],
            ['location', json_encode($entry['location'])],
            ['position', $entry['position']],
        ])->get());
    }
}
