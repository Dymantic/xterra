<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_event()
    {
        $this->withoutExceptionHandling();
        $event = factory(Event::class)->create();
        $race = factory(Activity::class)->create(['event_id' => $event->id]);

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
        ]);
        $this->assertDatabaseMissing('activities', [
            'id' => $race->id,
        ]);

    }
}
