<?php


namespace Tests\Feature\Events;


use App\Media\EmbeddableVideo;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttachPromoVideoForEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function add_the_promo_video_for_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/promo-video", [
           'video_id' => 'test_video_id',
           'title' => ['en' => 'test title', 'zh' => 'zh test title'],
        ]);
        $response->assertSuccessful();

        $this->assertNotNull($event->fresh()->promoVideo);
        $this->assertSame('test_video_id', $event->fresh()->promoVideo->getVideoId());
        $this->assertSame(EmbeddableVideo::YOUTUBE, $event->fresh()->promoVideo->getPlatform());
    }
}
