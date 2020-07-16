<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function publish_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->state('private')->create();

        $response = $this->asAdmin()->postJson("/admin/published-events", [
            'event_id' => $event->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
            'id'        => $event->id,
            'is_public' => true,
        ]);
    }
}
