<?php

namespace Tests\Unit\People;

use App\Media\EmbeddableVideo;
use App\People\Coach;
use App\People\CoachInfo;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoachesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function make_a_new_coach()
    {
        $coachInfo = new CoachInfo([
            'name'           => ['en' => "test name", 'zh' => "zh test name"],
            'location'       => ['en' => "test location", 'zh' => "zh test location"],
            'certifications' => ['en' => "test certifications", 'zh' => "zh test certifications"],
            'experience'     => ['en' => "test experience", 'zh' => "zh test experience"],
            'philosophy'     => ['en' => 'test philosophy', 'zh' => 'zh test philosophy'],
            'email'          => 'test@test.test',
            'phone'          => 'test phone',
            'website'        => 'https://test.test',
            'line'           => 'test_line_id',
            'social_links' => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/test'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/test'],
                ['platform' => 'instagram', 'link' => 'https://instagram.test/test'],
            ]
        ]);

        $coach = Coach::new($coachInfo);

        $this->assertInstanceOf(Coach::class, $coach);
        $this->assertSame('test name', $coach->name->in('en'));
        $this->assertSame('zh test name', $coach->name->in('zh'));
        $this->assertSame('test location', $coach->location->in('en'));
        $this->assertSame('zh test location', $coach->location->in('zh'));
        $this->assertSame('test certifications', $coach->certifications->in('en'));
        $this->assertSame('zh test certifications', $coach->certifications->in('zh'));
        $this->assertSame('test experience', $coach->experience->in('en'));
        $this->assertSame('zh test experience', $coach->experience->in('zh'));
        $this->assertSame('test philosophy', $coach->philosophy->in('en'));
        $this->assertSame('zh test philosophy', $coach->philosophy->in('zh'));
        $this->assertSame('test@test.test', $coach->email);
        $this->assertSame('test phone', $coach->phone);
        $this->assertSame('https://test.test', $coach->website);
        $this->assertSame('test_line_id', $coach->line);

        $this->assertCount(3, $coach->socialLinks);

        $this->assertTrue($coach->socialLinks->contains(
            fn ($link) => $link->platform === 'youtube' && $link->link === 'https://youtube.test/test')
        );

        $this->assertTrue($coach->socialLinks->contains(
            fn ($link) => $link->platform === 'linkdin' && $link->link === 'https://linkdin.test/test')
        );

        $this->assertTrue($coach->socialLinks->contains(
            fn ($link) => $link->platform === 'instagram' && $link->link === 'https://instagram.test/test')
        );
    }

    /**
     *@test
     */
    public function can_update_info()
    {
        $coach = factory(Coach::class)->create();
        $coachInfo = new CoachInfo([
            'name'           => ['en' => "new name", 'zh' => "zh new name"],
            'location'       => ['en' => "new location", 'zh' => "zh new location"],
            'certifications' => ['en' => "new certifications", 'zh' => "zh new certifications"],
            'experience'     => ['en' => "new experience", 'zh' => "zh new experience"],
            'philosophy'     => ['en' => 'new philosophy', 'zh' => 'zh new philosophy'],
            'email'          => 'new@test.test',
            'phone'          => 'new phone',
            'website'        => 'https://new.test',
            'line'           => 'new_line_id',
            'social_links' => [
                ['platform' => 'youtube', 'link' => 'https://youtube.test/new'],
                ['platform' => 'linkdin', 'link' => 'https://linkdin.test/new'],
                ['platform' => 'instagram', 'link' => 'https://instagram.test/new'],
            ]
        ]);

        $coach->updateInfo($coachInfo);

        $this->assertInstanceOf(Coach::class, $coach);
        $this->assertSame('new name', $coach->name->in('en'));
        $this->assertSame('zh new name', $coach->name->in('zh'));
        $this->assertSame('new location', $coach->location->in('en'));
        $this->assertSame('zh new location', $coach->location->in('zh'));
        $this->assertSame('new certifications', $coach->certifications->in('en'));
        $this->assertSame('zh new certifications', $coach->certifications->in('zh'));
        $this->assertSame('new experience', $coach->experience->in('en'));
        $this->assertSame('zh new experience', $coach->experience->in('zh'));
        $this->assertSame('new philosophy', $coach->philosophy->in('en'));
        $this->assertSame('zh new philosophy', $coach->philosophy->in('zh'));
        $this->assertSame('new@test.test', $coach->email);
        $this->assertSame('new phone', $coach->phone);
        $this->assertSame('https://new.test', $coach->website);
        $this->assertSame('new_line_id', $coach->line);

        $this->assertCount(3, $coach->socialLinks);

        $this->assertTrue($coach->socialLinks->contains(
            fn ($link) => $link->platform === 'youtube' && $link->link === 'https://youtube.test/new')
        );

        $this->assertTrue($coach->socialLinks->contains(
            fn ($link) => $link->platform === 'linkdin' && $link->link === 'https://linkdin.test/new')
        );

        $this->assertTrue($coach->socialLinks->contains(
            fn ($link) => $link->platform === 'instagram' && $link->link === 'https://instagram.test/new')
        );
    }

    /**
     *@test
     */
    public function can_fully_delete_coach()
    {
        $coach = factory(Coach::class)->create();
        $coach->setSocialLinks([
            ['platform' => 'youtube', 'link' => 'https://youtube.test/test'],
            ['platform' => 'instagram', 'link' => 'https://instagram.test/test'],
        ]);
        $coach->addYoutubeVideo('test_video_id', new Translation(['en' => "test title", 'zh' => "zh test title"]));

        $coach->fullDelete();

        $this->assertDatabaseMissing('coaches', ['id' => $coach->id]);
        $this->assertDatabaseMissing('social_links', ['sociable_id' => $coach->id]);
        $this->assertDatabaseMissing('embeddable_videos', [
            'videoed_id' => $coach->id,
            'videoed_type' => Coach::class
        ]);
    }

    /**
     *@test
     */
    public function can_add_youtube_video_for_coach()
    {
        $coach = factory(Coach::class)->create();

        $embeddable = $coach->addYoutubeVideo('test_video_id', new Translation(['en' => "test title", 'zh' => "zh test title"]));

        $this->assertSame($coach->id, $embeddable->videoed_id);
        $this->assertSame(Coach::class, $embeddable->videoed_type);
        $this->assertSame('test title', $embeddable->title->in('en'));
        $this->assertSame('zh test title', $embeddable->title->in('zh'));
        $this->assertSame('test_video_id', $embeddable->video_id);
        $this->assertSame(EmbeddableVideo::YOUTUBE, $embeddable->platform);
    }

    /**
     *@test
     */
    public function can_publish_a_coach()
    {
        $coach = factory(Coach::class)->state('private')->create();

        $coach->publish();

        $this->assertTrue($coach->is_public);
    }

    /**
     *@test
     */
    public function can_retract_a_coach()
    {
        $coach = factory(Coach::class)->state('public')->create();

        $coach->retract();

        $this->assertFalse($coach->is_public);
    }
}
