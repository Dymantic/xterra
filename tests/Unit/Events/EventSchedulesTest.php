<?php


namespace Tests\Unit\Events;


use App\Occasions\Event;
use App\Occasions\Schedule;
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
                        'time_of_day' => '6:30am',
                        'item'        => ['en' => 'test item one', 'zh' => 'zh test item one'],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => '8:45',
                        'item'        => ['en' => 'test item two', 'zh' => 'zh test item two'],
                        'position'    => 2,
                    ],
                    [
                        'time_of_day' => '12:00',
                        'item'        => ['en' => 'test item three', 'zh' => 'zh test item three'],
                        'position'    => 3,
                    ],
                ]
            ],
            [
                'day'     => 2,
                'entries' => [
                    [
                        'time_of_day' => '6:30am',
                        'item'        => ['en' => 'test item one', 'zh' => 'zh test item one'],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => '8:45',
                        'item'        => ['en' => 'test item two', 'zh' => 'zh test item two'],
                        'position'    => 3,
                    ],
                    [
                        'time_of_day' => '7:00',
                        'item'        => ['en' => 'test item three', 'zh' => 'zh test item three'],
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
            'time_of_day'  => '6:30am',
            'item'         => ['en' => 'test item one', 'zh' => 'zh test item one'],
            'position'     => 1,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 1,
            'time_of_day'  => '8:45',
            'item'         => ['en' => 'test item two', 'zh' => 'zh test item two'],
            'position'     => 2,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 1,
            'time_of_day'  => '12:00',
            'item'         => ['en' => 'test item three', 'zh' => 'zh test item three'],
            'position'     => 3,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 2,
            'time_of_day'  => '6:30am',
            'item'         => ['en' => 'test item one', 'zh' => 'zh test item one'],
            'position'     => 1,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 2,
            'time_of_day'  => '8:45',
            'item'         => ['en' => 'test item two', 'zh' => 'zh test item two'],
            'position'     => 3,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 2,
            'time_of_day'  => '7:00',
            'item'         => ['en' => 'test item three', 'zh' => 'zh test item three'],
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
                        'time_of_day' => '5am',
                        'item'        => ['en' => 'old item one', 'zh' => 'zh old item one'],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => '7am',
                        'item'        => ['en' => 'old item two', 'zh' => 'zh old item two'],
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
                        'time_of_day' => '9am',
                        'item'        => ['en' => 'new item one', 'zh' => 'zh new item one'],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => '11am',
                        'item'        => ['en' => 'new item two', 'zh' => 'zh new item two'],
                        'position'    => 2,
                    ]
                ]
            ]
        ]);

        $event->setSchedule($new_schedule);

        $this->assertCount(2, $event->scheduleEntries);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 1,
            'time_of_day'  => '9am',
            'item'         => ['en' => 'new item one', 'zh' => 'zh new item one'],
            'position'     => 1,
        ]);

        $this->assertEventHasScheduleEntry($event, [
            'day_of_event' => 1,
            'time_of_day'  => '11am',
            'item'         => ['en' => 'new item two', 'zh' => 'zh new item two'],
            'position'     => 2,
        ]);
    }

    /**
     *@test
     */
    public function can_clear_the_schedule()
    {
        $event = factory(Event::class)->create();

        $schedule = new Schedule([
            [
                'day'     => 1,
                'entries' => [
                    [
                        'time_of_day' => '9am',
                        'item'        => ['en' => 'new item one', 'zh' => 'zh new item one'],
                        'position'    => 1,
                    ],
                    [
                        'time_of_day' => '11am',
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

    private function assertEventHasScheduleEntry($event, $entry)
    {
        $this->assertCount(1, $event->scheduleEntries()->where([
            ['day_of_event', $entry['day_of_event']],
            ['time_of_day', $entry['time_of_day']],
            ['item', json_encode($entry['item'])],
            ['position', $entry['position']],
        ])->get());
    }
}
