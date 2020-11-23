<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use App\People\Ambassador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachAmbassadorToEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function attach_an_ambassador_to_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $ambassador = factory(Ambassador::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/ambassadors", [
            'ambassador_id' => $ambassador->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('attendees', [
            'attendees_id' => $ambassador->id,
            'attendees_type' => Ambassador::class,
            'event_id' => $event->id,
        ]);

        $this->assertCount(1, $event->ambassadors);
    }

    /**
     *@test
     */
    public function the_ambassador_id_is_required_to_exist_in_db()
    {
        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/ambassadors", [
            'ambassador_id' => 99,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('ambassador_id');
    }

    /**
     *@test
     */
    public function the_ambassador_cannot_already_belong_to_event()
    {
        $event = factory(Event::class)->create();
        $ambassador = factory(Ambassador::class)->create();
        $event->ambassadors()->attach($ambassador->id);

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/ambassadors", [
            'ambassador_id' => $ambassador->id,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('ambassador_id');
    }
}
