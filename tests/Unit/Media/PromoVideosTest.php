<?php


namespace Tests\Unit\Media;


use App\Media\EmbeddableVideo;
use App\Media\PromoVideo;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromoVideosTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function make_a_new_promo_video()
    {
        $promo_video = PromoVideo::new('test_video_id', new Translation(['en' => "test title", 'zh' => "zh test title"]));

        $this->assertSame(EmbeddableVideo::YOUTUBE, $promo_video->getPlatform());
        $this->assertSame('test_video_id', $promo_video->getVideoId());

        $embedded_video = $promo_video->embeddableVideos()->first();

        $this->assertNotNull($embedded_video);
    }
}
