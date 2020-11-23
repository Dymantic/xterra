<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use App\People\Ambassador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DetachAmbassadorFromEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function detach_an_ambassador_from_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $ambassador = factory(Ambassador::class)->create();
        $event->ambassadors()->attach($ambassador->id);
        $this->assertCount(1, $event->fresh()->ambassadors);

        $response = $this
            ->asAdmin()
            ->deleteJson("/admin/events/{$event->id}/ambassadors/{$ambassador->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('attendees', [
            'attendees_id' => $ambassador->id,
            'attendees_type' => Ambassador::class,
            'event_id' => $event->id,
        ]);

        $this->assertCount(0, $event->fresh()->ambassadors);

    }
}
