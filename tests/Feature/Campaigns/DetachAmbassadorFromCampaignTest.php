<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\People\Ambassador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DetachAmbassadorFromCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_an_ambassador_from_a_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $ambassador = factory(Ambassador::class)->create();
        $campaign->ambassadors()->attach($ambassador->id);

        $this->assertCount(1, $campaign->fresh()->ambassadors);

        $response = $this
            ->asAdmin()
            ->deleteJson("/admin/campaigns/{$campaign->id}/ambassadors/{$ambassador->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('representatives', [
            'representative_id'   => $ambassador->id,
            'representative_type' => Ambassador::class,
            'campaign_id'         => $campaign->id,
        ]);

        $this->assertCount(0, $campaign->fresh()->ambassadors);
    }
}
