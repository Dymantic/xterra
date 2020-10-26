<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function publish_a_campaign()
    {
        $this->withoutExceptionHandling();
        $campaign = factory(Campaign::class)->state('private')->create();

        $response = $this->asAdmin()->postJson("/admin/published-campaigns", [
            'campaign_id' => $campaign->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'is_public' => true,
        ]);
    }
}
