<?php


namespace Tests\Feature\HomePage;


use App\HomePage;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachEventToHomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function attach_an_existing_event_on_the_home_page()
    {
        $this->withoutExceptionHandling();
        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/home-page/featured-event", [
            'event_id' => $event->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('home_pages', [
            'id' => HomePage::current()->id,
            'event_id' => $event->id,
        ]);
    }

    /**
     *@test
     */
    public function the_event_must_exist_in_the_events_table()
    {
        $response = $this->asAdmin()->postJson("/admin/home-page/featured-event", [
            'event_id' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('event_id');

        $response = $this->asAdmin()->postJson("/admin/home-page/featured-event", [
            'event_id' => 5987,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('event_id');
    }
}
