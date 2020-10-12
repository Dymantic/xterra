<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClearEventPromoVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_promo_video_on_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $promo = $event->setPromoVideo('test_video_id', new Translation(['en' => "test title", 'zh' => "zh test title"]));

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}/promo-video");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('promo_videos', ['id' => $promo->id]);
        $this->assertDatabaseHas('events', [
            "id" => $event->id,
            'promo_video_id' => null,
        ]);

    }
}
