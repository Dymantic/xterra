<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DetachCoachFromEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function remove_a_coach_from_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $coach = factory(Coach::class)->create();
        $event->coaches()->attach($coach->id);
        $this->assertCount(1, $event->fresh()->coaches);

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}/coaches/{$coach->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('attendees', [
            'event_id'       => $event->id,
            'attendees_id'    => $coach->id,
            'attendees_type' => Coach::class,
        ]);


    }
}
