<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use App\Occasions\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClearEventScheduleTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_an_existing_event_schedule()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
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
        $event->setSchedule($schedule);

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}/schedule");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('schedule_entries', [
            'scheduled_id' => $event->id,
            'scheduled_type' => Event::class,
        ]);
    }
}
