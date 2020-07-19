<?php


namespace Tests\Unit\Events;


use App\Media\EmbeddableVideo;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventYoutubeVideosTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_attach_youtube_video_to_event()
    {
        $event = factory(Event::class)->create();

        $video = $event->attachYoutubeVideo('test-video-id', ['en' => "test title", 'zh' => "zh test title"]);

        $this->assertCount(1, $event->fresh()->embeddableVideos);
        $this->assertTrue($event->fresh()->embeddableVideos->first()->is($video));

        $this->assertInstanceOf(EmbeddableVideo::class, $video);
        $this->assertEquals($event->id, $video->videoed_id);
        $this->assertEquals(Event::class, $video->videoed_type);
        $this->assertEquals(['en' => "test title", 'zh' => "zh test title"], $video->title);
        $this->assertEquals('test-video-id', $video->video_id);
        $this->assertEquals(EmbeddableVideo::YOUTUBE, $video->platform);

    }
}
