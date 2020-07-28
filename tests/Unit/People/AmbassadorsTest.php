<?php


namespace Tests\Unit\People;


use App\Media\EmbeddableVideo;
use App\People\Ambassador;
use App\People\AmbassadorInfo;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AmbassadorsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_an_ambassador()
    {
        $ambassadorInfo = new AmbassadorInfo([
            'name'          => ['en' => 'test name', 'zh' => 'zh test name'],
            'about'         => ['en' => 'test about', 'zh' => 'zh test about'],
            'achievements'  => ['en' => 'test achievements', 'zh' => 'zh test achievements'],
            'collaboration' => ['en' => 'test collaboration', 'zh' => 'zh test collaboration'],
            'philosophy'    => ['en' => 'test philosophy', 'zh' => 'zh test philosophy'],
            'social_links'  => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/test'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/test'],
                ['platform' => 'instagram', 'link' => 'https://instagram.test/test'],
            ]
        ]);

        $ambassador = Ambassador::new($ambassadorInfo);

        $this->assertInstanceOf(Ambassador::class, $ambassador);
        $this->assertSame('test name', $ambassador->name->in('en'));
        $this->assertSame('zh test name', $ambassador->name->in('zh'));
        $this->assertSame('test about', $ambassador->about->in('en'));
        $this->assertSame('zh test about', $ambassador->about->in('zh'));
        $this->assertSame('test achievements', $ambassador->achievements->in('en'));
        $this->assertSame('zh test achievements', $ambassador->achievements->in('zh'));
        $this->assertSame('test collaboration', $ambassador->collaboration->in('en'));
        $this->assertSame('zh test collaboration', $ambassador->collaboration->in('zh'));
        $this->assertSame('test philosophy', $ambassador->philosophy->in('en'));
        $this->assertSame('zh test philosophy', $ambassador->philosophy->in('zh'));

        $this->assertCount(3, $ambassador->socialLinks);

        $this->assertTrue($ambassador->socialLinks->contains(
            fn($link) => $link->platform === 'youtube' && $link->link === 'https://youtube.test/test'
        ));

        $this->assertTrue($ambassador->socialLinks->contains(
            fn($link) => $link->platform === 'linkdin' && $link->link === 'https://linkdin.test/test'
        ));

        $this->assertTrue($ambassador->socialLinks->contains(
            fn($link) => $link->platform === 'instagram' && $link->link === 'https://instagram.test/test'
        ));
    }

    /**
     * @test
     */
    public function can_update_with_ambassador_info()
    {
        $ambassador = factory(Ambassador::class)->create();
        $ambassadorInfo = new AmbassadorInfo([
            'name'          => ['en' => 'new name', 'zh' => 'zh new name'],
            'about'         => ['en' => 'new about', 'zh' => 'zh new about'],
            'achievements'  => ['en' => 'new achievements', 'zh' => 'zh new achievements'],
            'collaboration' => ['en' => 'new collaboration', 'zh' => 'zh new collaboration'],
            'philosophy'    => ['en' => 'new philosophy', 'zh' => 'zh new philosophy'],
            'social_links'  => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/new'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/new'],
            ]
        ]);

        $ambassador->updateInfo($ambassadorInfo);

        $this->assertInstanceOf(Ambassador::class, $ambassador);
        $this->assertSame('new name', $ambassador->name->in('en'));
        $this->assertSame('zh new name', $ambassador->name->in('zh'));
        $this->assertSame('new about', $ambassador->about->in('en'));
        $this->assertSame('zh new about', $ambassador->about->in('zh'));
        $this->assertSame('new achievements', $ambassador->achievements->in('en'));
        $this->assertSame('zh new achievements', $ambassador->achievements->in('zh'));
        $this->assertSame('new collaboration', $ambassador->collaboration->in('en'));
        $this->assertSame('zh new collaboration', $ambassador->collaboration->in('zh'));
        $this->assertSame('new philosophy', $ambassador->philosophy->in('en'));
        $this->assertSame('zh new philosophy', $ambassador->philosophy->in('zh'));

        $this->assertCount(2, $ambassador->socialLinks);

        $this->assertTrue($ambassador->socialLinks->contains(
            fn($link) => $link->platform === 'youtube' && $link->link === 'https://youtube.test/new'
        ));

        $this->assertTrue($ambassador->socialLinks->contains(
            fn($link) => $link->platform === 'linkdin' && $link->link === 'https://linkdin.test/new'
        ));
    }

    /**
     * @test
     */
    public function fully_delete_an_ambassador()
    {
        $ambassador = factory(Ambassador::class)->create();
        $ambassador->setSocialLinks([['platform' => 'youtube', 'link' => 'https://youtube.test/test']]);
        $ambassador->addYoutubeVideo('test_video_id', new Translation(['en' => "yo", 'zh' => "zh yo"]));

        $ambassador->fullDelete();

        $this->assertDatabaseMissing('ambassadors', ['id' => $ambassador->id]);

        $this->assertDatabaseMissing('embeddable_videos', [
            'videoed_id'   => $ambassador->id,
            'videoed_type' => Ambassador::class,
        ]);

        $this->assertDatabaseMissing('social_links', [
            'sociable_id'   => $ambassador->id,
            'sociable_type' => Ambassador::class,
        ]);

    }

    /**
     * @test
     */
    public function can_publish_an_ambassador()
    {
        $ambassador = factory(Ambassador::class)->state('private')->create();

        $ambassador->publish();

        $this->assertTrue($ambassador->fresh()->is_public);
    }

    /**
     * @test
     */
    public function can_retract_an_ambassador()
    {
        $ambassador = factory(Ambassador::class)->state('public')->create();

        $ambassador->retract();

        $this->assertFalse($ambassador->fresh()->is_public);
    }

    /**
     * @test
     */
    public function add_youtube_video()
    {
        $ambassador = factory(Ambassador::class)->create();
        $video_title = new Translation(['en' => "test title", 'zh' => "zh test title"]);

        $video = $ambassador->addYoutubeVideo('test_video_id', $video_title);

        $this->assertInstanceOf(EmbeddableVideo::class, $video);
        $this->assertSame($ambassador->id, $video->videoed_id);
        $this->assertSame(Ambassador::class, $video->videoed_type);
        $this->assertSame('test title', $video->title->in('en'));
        $this->assertSame('zh test title', $video->title->in('zh'));
        $this->assertSame('test_video_id', $video->video_id);

    }


}
