<?php


namespace Tests\Unit\Media;


use App\Media\EmbeddableVideo;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmbeddableVideosTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_update_the_video_title()
    {
        $video = factory(EmbeddableVideo::class)->create();

        $video->updateTitle(new Translation(['en' => "test title", 'zh' => "zh test title"]));

        $this->assertEquals('test title', $video->fresh()->title->in('en'));
        $this->assertEquals('zh test title', $video->fresh()->title->in('zh'));
    }

    /**
     *@test
     */
    public function can_update_video_info()
    {
        $video = factory(EmbeddableVideo::class)->create();

        $video->updateInfo('new_video_id', new Translation(['en' => "test title", 'zh' => "zh test title"]));

        $this->assertEquals('new_video_id', $video->fresh()->video_id);
        $this->assertEquals('test title', $video->fresh()->title->in('en'));
        $this->assertEquals('zh test title', $video->fresh()->title->in('zh'));
    }
}
