<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetractEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function retract_an_event()
    {
        $this->withoutExceptionHandling();
        $event = factory(Event::class)->state('public')->create();

        $response = $this->asAdmin()->deleteJson("/admin/published-events/{$event->id}");
        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
            'id'        => $event->id,
            'is_public' => false,
        ]);
    }
}
