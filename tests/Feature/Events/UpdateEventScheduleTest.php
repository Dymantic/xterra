<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateEventScheduleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function set_the_event_schedule()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/schedule", [
            'schedule' => [
                [
                    'day'     => 1,
                    'entries' => [
                        [
                            'time_of_day' => ['en' => '6:30am', 'zh' => '6:30am'],
                            'item'        => ['en' => 'test item one', 'zh' => 'zh test item one'],
                            'position'    => 1,
                        ],
                        [
                            'time_of_day' => ['en' => '8:45', 'zh' => '8:45'],
                            'item'        => ['en' => 'test item two', 'zh' => 'zh test item two'],
                            'position'    => 2,
                        ],
                        [
                            'time_of_day' => ['en' => '12:00', 'zh' => '12:00'],
                            'item'        => ['en' => 'test item three', 'zh' => 'zh test item three'],
                            'position'    => 3,
                        ],
                    ]
                ],
                [
                    'day'     => 2,
                    'entries' => [
                        [
                            'time_of_day' => ['en' => '6:25am', 'zh' => '6:25am'],
                            'item'        => ['en' => 'test item one', 'zh' => 'zh test item one'],
                            'position'    => 1,
                        ],
                        [
                            'time_of_day' => ['en' => '1pm', 'zh' => '1pm'],
                            'item'        => ['en' => 'test item two', 'zh' => 'zh test item two'],
                            'position'    => 3,
                        ],
                        [
                            'time_of_day' => ['en' => '7:00', 'zh' => '7:00'],
                            'item'        => ['en' => 'test item three', 'zh' => 'zh test item three'],
                            'position'    => 2,
                        ],
                    ]
                ]
            ]
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('schedule_entries', [
            'event_id'     => $event->id,
            'day_of_event' => 1,
            'time_of_day'  => json_encode(['en' => '6:30am', 'zh' => '6:30am']),
            'item'         => json_encode(['en' => 'test item one', 'zh' => 'zh test item one']),
            'position'     => 1,
        ]);

        $this->assertDatabaseHas('schedule_entries', [
            'event_id'     => $event->id,
            'day_of_event' => 1,
            'time_of_day'  => json_encode(['en' => '8:45', 'zh' => '8:45']),
            'item'         => json_encode(['en' => 'test item two', 'zh' => 'zh test item two']),
            'position'     => 2,
        ]);

        $this->assertDatabaseHas('schedule_entries', [
            'event_id'     => $event->id,
            'day_of_event' => 1,
            'time_of_day'  => json_encode(['en' => '12:00', 'zh' => '12:00']),
            'item'         => json_encode(['en' => 'test item three', 'zh' => 'zh test item three']),
            'position'     => 3,
        ]);

        $this->assertDatabaseHas('schedule_entries', [
            'event_id'     => $event->id,
            'day_of_event' => 2,
            'time_of_day'  => json_encode(['en' => '6:25am', 'zh' => '6:25am']),
            'item'         => json_encode(['en' => 'test item one', 'zh' => 'zh test item one']),
            'position'     => 1,
        ]);

        $this->assertDatabaseHas('schedule_entries', [
            'event_id'     => $event->id,
            'day_of_event' => 2,
            'time_of_day'  => json_encode(['en' => '7:00', 'zh' => '7:00']),
            'item'         => json_encode(['en' => 'test item three', 'zh' => 'zh test item three']),
            'position'     => 2,
        ]);

        $this->assertDatabaseHas('schedule_entries', [
            'event_id'     => $event->id,
            'day_of_event' => 2,
            'time_of_day'  => json_encode(['en' => '1pm', 'zh' => '1pm']),
            'item'         => json_encode(['en' => 'test item two', 'zh' => 'zh test item two']),
            'position'     => 3,
        ]);
    }

    /**
     * @test
     */
    public function the_schedule_is_required()
    {
        $this->assertFieldIsInvalid(['schedule' => null]);
    }

    /**
     * @test
     */
    public function the_schedule_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['schedule' => 'not-an-array']);
    }

    /**
     * @test
     */
    public function the_schedule_array_entries_must_have_the_day()
    {
        $this->assertFieldIsInvalid([
            'schedule' => [
                [
                    'entries' => [
                        [
                            'time_of_day' => '4am',
                            'item'        => ['en' => 'test item', 'zh' => 'zh test item'],
                            'position'    => 1
                        ]
                    ]
                ]
            ]
        ], 'schedule.0.day');
    }

    /**
     * @test
     */
    public function the_schedule_day_must_be_an_integer()
    {
        $this->assertFieldIsInvalid([
            'schedule' => [
                [
                    'day'     => 'not-an-integer',
                    'entries' => [
                        [
                            'time_of_day' => '4am',
                            'item'        => ['en' => 'test item', 'zh' => 'zh test item'],
                            'position'    => 1
                        ]
                    ]
                ]
            ]
        ], 'schedule.0.day');
    }

    /**
     *@test
     */
    public function the_schedule_items_must_requires_entries()
    {
        $this->assertFieldIsInvalid([
            'schedule' => [
                [
                    'day'     => 1,
                    'entries' => null
                ]
            ]
        ], 'schedule.0.entries');
    }

    /**
     *@test
     */
    public function the_schedule_entries_must_be_an_array()
    {
        $this->assertFieldIsInvalid([
            'schedule' => [
                [
                    'day'     => 1,
                    'entries' => 'not-an-array'
                ]
            ]
        ], 'schedule.0.entries');
    }

    /**
     *@test
     */
    public function the_schedule_entries_requires_a_time_of_day()
    {
        $this->assertFieldIsInvalid([
            'schedule' => [
                [
                    'day'     => 1,
                    'entries' => [
                        [
                            'time_of_day' => null,
                            'item'        => ['en' => 'test item', 'zh' => 'zh test item'],
                            'position'    => 1
                        ]
                    ]
                ]
            ]
        ], 'schedule.0.entries.0.time_of_day');
    }

    /**
     *@test
     */
    public function the_schedule_entries_requires_a_time_of_day_with_at_least_translation()
    {
        $this->assertFieldIsInvalid([
            'schedule' => [
                [
                    'day'     => 1,
                    'entries' => [
                        [
                            'time_of_day' => [],
                            'item'        => ['en' => ''],
                            'position'    => 1
                        ]
                    ]
                ]
            ]
        ], 'schedule.0.entries.0.item');
    }

    /**
     *@test
     */
    public function the_schedule_entries_requires_an_item_with_at_least_translation()
    {
        $this->assertFieldIsInvalid([
            'schedule' => [
                [
                    'day'     => 1,
                    'entries' => [
                        [
                            'time_of_day' => '6am',
                            'item'        => ['en' => ''],
                            'position'    => 1
                        ]
                    ]
                ]
            ]
        ], 'schedule.0.entries.0.item');
    }

    /**
     *@test
     */
    public function the_schedule_entries_requires_a_position()
    {
        $this->assertFieldIsInvalid([
            'schedule' => [
                [
                    'day'     => 1,
                    'entries' => [
                        [
                            'time_of_day' => '6am',
                            'item'        => ['en' => 'test item', 'zh' => 'zh test item'],
                            'position'    => null
                        ]
                    ]
                ]
            ]
        ], 'schedule.0.entries.0.position');
    }

    /**
     *@test
     */
    public function the_position_needs_to_be_an_integer()
    {
        $this->assertFieldIsInvalid([
            'schedule' => [
                [
                    'day'     => 1,
                    'entries' => [
                        [
                            'time_of_day' => '6am',
                            'item'        => ['en' => 'test item', 'zh' => 'zh test item'],
                            'position'    => 'not-an-integer'
                        ]
                    ]
                ]
            ]
        ], 'schedule.0.entries.0.position');
    }

    private function assertFieldIsInvalid($field, $error_key = null)
    {
        $event = factory(Event::class)->create();

        $valid = [
            'schedule' => [
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
            ]
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/events/{$event->id}/schedule", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
