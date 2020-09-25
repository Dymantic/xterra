<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateRaceScheduleTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_the_schedule_for_a_race()
    {
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/schedule", [
            'schedule' => [
                [
                    'day'     => 1,
                    'entries' => [
                        [
                            'time_of_day' => ['en' => '6:30am', 'zh' => '6:30am'],
                            'item'        => ['en' => 'test item one', 'zh' => 'zh test item one'],
                            'location'    => ['en' => 'test location', 'zh' => 'zh test location'],
                            'position'    => 1,
                        ],
                        [
                            'time_of_day' => ['en' => '8:45', 'zh' => '8:45'],
                            'item'        => ['en' => 'test item two', 'zh' => 'zh test item two'],
                            'location'    => ['en' => 'test location', 'zh' => 'zh test location'],
                            'position'    => 2,
                        ],
                        [
                            'time_of_day' => ['en' => '12:00', 'zh' => '12:00'],
                            'item'        => ['en' => 'test item three', 'zh' => 'zh test item three'],
                            'location'    => ['en' => 'test location', 'zh' => 'zh test location'],
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
                            'location'    => ['en' => 'test location', 'zh' => 'zh test location'],
                            'position'    => 1,
                        ],
                        [
                            'time_of_day' => ['en' => '1pm', 'zh' => '1pm'],
                            'item'        => ['en' => 'test item two', 'zh' => 'zh test item two'],
                            'location'    => ['en' => 'test location', 'zh' => 'zh test location'],
                            'position'    => 3,
                        ],
                        [
                            'time_of_day' => ['en' => '7:00', 'zh' => '7:00'],
                            'item'        => ['en' => 'test item three', 'zh' => 'zh test item three'],
                            'location'    => ['en' => 'test location', 'zh' => 'zh test location'],
                            'position'    => 2,
                        ],
                    ]
                ]
            ]
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('schedule_entries', [
            'scheduled_id'     => $race->id,
            'scheduled_type' => Activity::class,
            'day_of_event' => 1,
            'time_of_day'  => json_encode(['en' => '6:30am', 'zh' => '6:30am']),
            'item'         => json_encode(['en' => 'test item one', 'zh' => 'zh test item one']),
            'location'     => json_encode(['en' => 'test location', 'zh' => 'zh test location']),
            'position'     => 1,
        ]);

        $this->assertDatabaseHas('schedule_entries', [
            'scheduled_id'     => $race->id,
            'scheduled_type' => Activity::class,
            'day_of_event' => 1,
            'time_of_day'  => json_encode(['en' => '8:45', 'zh' => '8:45']),
            'item'         => json_encode(['en' => 'test item two', 'zh' => 'zh test item two']),
            'location'     => json_encode(['en' => 'test location', 'zh' => 'zh test location']),
            'position'     => 2,
        ]);

        $this->assertDatabaseHas('schedule_entries', [
            'scheduled_id'     => $race->id,
            'scheduled_type' => Activity::class,
            'day_of_event' => 1,
            'time_of_day'  => json_encode(['en' => '12:00', 'zh' => '12:00']),
            'item'         => json_encode(['en' => 'test item three', 'zh' => 'zh test item three']),
            'location'     => json_encode(['en' => 'test location', 'zh' => 'zh test location']),
            'position'     => 3,
        ]);

        $this->assertDatabaseHas('schedule_entries', [
            'scheduled_id'     => $race->id,
            'scheduled_type' => Activity::class,
            'day_of_event' => 2,
            'time_of_day'  => json_encode(['en' => '6:25am', 'zh' => '6:25am']),
            'item'         => json_encode(['en' => 'test item one', 'zh' => 'zh test item one']),
            'location'     => json_encode(['en' => 'test location', 'zh' => 'zh test location']),
            'position'     => 1,
        ]);

        $this->assertDatabaseHas('schedule_entries', [
            'scheduled_id'     => $race->id,
            'scheduled_type' => Activity::class,
            'day_of_event' => 2,
            'time_of_day'  => json_encode(['en' => '7:00', 'zh' => '7:00']),
            'item'         => json_encode(['en' => 'test item three', 'zh' => 'zh test item three']),
            'location'     => json_encode(['en' => 'test location', 'zh' => 'zh test location']),
            'position'     => 2,
        ]);

        $this->assertDatabaseHas('schedule_entries', [
            'scheduled_id'     => $race->id,
            'scheduled_type' => Activity::class,
            'day_of_event' => 2,
            'time_of_day'  => json_encode(['en' => '1pm', 'zh' => '1pm']),
            'item'         => json_encode(['en' => 'test item two', 'zh' => 'zh test item two']),
            'location'     => json_encode(['en' => 'test location', 'zh' => 'zh test location']),
            'position'     => 3,
        ]);
    }
}
