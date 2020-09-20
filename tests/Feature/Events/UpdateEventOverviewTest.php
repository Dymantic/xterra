<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateEventOverviewTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_the_overview_for_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/overview", [
            'overview' => ['en' => 'test overview', 'zh' => 'zh test overview']
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'overview' => json_encode(['en' => 'test overview', 'zh' => 'zh test overview']),
        ]);
    }
}
