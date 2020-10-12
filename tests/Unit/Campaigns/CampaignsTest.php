<?php

namespace Tests\Unit\Campaigns;

use App\Blog\Article;
use App\Campaigns\Campaign;
use App\Campaigns\CampaignInfo;
use App\Media\EmbeddableVideo;
use App\Media\PromoVideo;
use App\Occasions\Event;
use App\Shop\Promotion;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_make_new_campaign()
    {
        $campaignInfo = new CampaignInfo([
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
            'intro' => ['en' => 'test intro', 'zh' => 'zh test intro'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
        ]);

        $campaign = Campaign::new($campaignInfo);

        $this->assertSame('test title', $campaign->title->in('en'));
        $this->assertSame('zh test title', $campaign->title->in('zh'));

        $this->assertSame('test intro', $campaign->intro->in('en'));
        $this->assertSame('zh test intro', $campaign->intro->in('zh'));

        $this->assertSame('test description', $campaign->description->in('en'));
        $this->assertSame('zh test description', $campaign->description->in('zh'));

        $this->assertSame('', $campaign->narrative->in('en'));
        $this->assertSame('', $campaign->narrative->in('zh'));

        $this->assertNotNull($campaign->slug);
    }

    /**
     *@test
     */
    public function can_update_the_narrative()
    {
        $campaign = factory(Campaign::class)->create();

        $campaign->updateNarrative("test narrative", 'en');
        $campaign->refresh();

        $this->assertSame('test narrative', $campaign->narrative->in('en'));
        $this->assertSame('', $campaign->narrative->in('zh'));

        $campaign->updateNarrative("test zh narrative", 'zh');
        $campaign->refresh();

        $this->assertSame('test narrative', $campaign->narrative->in('en'));
        $this->assertSame('test zh narrative', $campaign->narrative->in('zh'));
    }

    /**
     *@test
     */
    public function can_set_the_event()
    {
        $campaign = factory(Campaign::class)->create();
        $event = factory(Event::class)->create();

        $campaign->setEvent($event);

        $this->assertTrue($campaign->event->is($event));
    }

    /**
     *@test
     */
    public function can_set_the_promotion()
    {
        $campaign = factory(Campaign::class)->create();
        $promo = factory(Promotion::class)->create();

        $campaign->setPromotion($promo);

        $this->assertTrue($campaign->fresh()->promotion->is($promo));
    }

    /**
     *@test
     */
    public function can_attach_an_article()
    {
        $campaign = factory(Campaign::class)->create();
        $article = factory(Article::class)->create();

        $campaign->attachArticle($article);

        $this->assertTrue($campaign->fresh()->articles->contains($article));
    }

    /**
     *@test
     */
    public function can_remove_an_article_from_a_campaign()
    {
        $campaign = factory(Campaign::class)->create();
        $article = factory(Article::class)->create();
        $campaign->attachArticle($article);

        $campaign->removeArticle($article);

        $this->assertFalse($campaign->fresh()->articles->contains($article));
    }

    /**
     *@test
     */
    public function can_set_the_promo_video()
    {
        $campaign = factory(Campaign::class)->create();

        $video = $campaign->setPromoVideo('test_video_id', new Translation(['en' => "test title", 'zh' => "zh test title"]));

        $this->assertInstanceOf(PromoVideo::class, $video);
        $actual_video = $video->embeddableVideos->first();

        $this->assertSame('test_video_id', $actual_video->video_id);
        $this->assertSame(EmbeddableVideo::YOUTUBE, $actual_video->platform);
        $this->assertSame(PromoVideo::class, $actual_video->videoed_type);
        $this->assertEquals($video->id, $actual_video->videoed_id);

    }

    /**
     *@test
     */
    public function setting_promo_video_overwrites_older_ones()
    {
        $campaign = factory(Campaign::class)->create();

        $old_promo_video = $campaign->setPromoVideo('test_video_id', new Translation(['en' => "test title", 'zh' => "zh test title"]));


        $new_video = $campaign->setPromoVideo('new_video_id', new Translation(['en' => "test title", 'zh' => "zh test title"]));

        $this->assertEquals($campaign->fresh()->promoVideo->id, $new_video->id);
        $this->assertNull($old_promo_video->fresh());


    }
}
