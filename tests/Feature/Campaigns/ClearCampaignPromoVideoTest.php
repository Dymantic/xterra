<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClearCampaignPromoVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_current_promo_video_for_the_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $promo = $campaign->setPromoVideo('test_video_id', new Translation(['en' => "test title", 'zh' => "zh test title"]));

        $response = $this->asAdmin()->deleteJson("/admin/campaigns/{$campaign->id}/promo-video");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('promo_videos', ['id' => $promo->id]);
        $this->assertDatabaseHas('campaigns', [
            "id" => $campaign->id,
            'promo_video_id' => null,
        ]);

    }
}
