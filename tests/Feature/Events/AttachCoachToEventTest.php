<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachCoachToEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function attach_a_coach_to_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $coach = factory(Coach::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/coaches", [
            'coach_id' => $coach->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('attendees', [
            'attendees_id' => $coach->id,
            'attendees_type' => Coach::class,
            'event_id' => $event->id,
        ]);
    }

    /**
     *@test
     */
    public function the_coach_id_is_required_to_exist_is_the_db()
    {
        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/coaches", [
            'coach_id' => 99,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('coach_id');
    }

    /**
     *@test
     */
    public function the_coach_cannot_already_be_attached()
    {
        $event = factory(Event::class)->create();
        $coach = factory(Coach::class)->create();
        $event->coaches()->attach($coach);

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/coaches", [
            'coach_id' => $coach->id,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('coach_id');
    }
}
