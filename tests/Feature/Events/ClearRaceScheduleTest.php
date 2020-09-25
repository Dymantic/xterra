<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use App\Occasions\Event;
use App\Occasions\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClearRaceScheduleTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_schedule_from_a_race()
    {
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();
        $schedule = new Schedule([
            [
                'day' => 1,
                'entries' => [
                    [
                        'time_of_day' => 'morning',
                        'item' => ['en' => 'test item', 'zh' => 'zh test item'],
                        'position' => 1
                    ]
                ]
            ]
        ]);
        $race->setSchedule($schedule);

        $response = $this->asAdmin()->deleteJson("/admin/races/{$race->id}/schedule");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('schedule_entries', [
            'scheduled_id' => $race->id,
            'scheduled_type' => Activity::class,
            ]);
    }
}
