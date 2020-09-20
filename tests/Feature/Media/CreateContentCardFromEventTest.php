<?php


namespace Tests\Feature\Media;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class CreateContentCardFromEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_a_content_card_from_a_given_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/event-content-cards", [
            'event_id' => $event->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('content_cards', [
            'category' => json_encode([
                'en' => Lang::get('content-cards.event', [], 'en'),
                'zh' => Lang::get('content-cards.event', [], 'zh'),
            ]),
            'title' => json_encode([
                'en' => $event->name['en'],
                'zh' => $event->name['zh'],
            ]),
            'link' => "/events/{$event->slug}",
        ]);
    }
}
