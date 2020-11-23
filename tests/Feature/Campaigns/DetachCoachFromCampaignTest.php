<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DetachCoachFromCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_a_coach_from_a_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $coach = factory(Coach::class)->create();
        $campaign->coaches()->attach($coach->id);

        $this->assertCount(1, $campaign->fresh()->coaches);

        $response = $this->asAdmin()->deleteJson("/admin/campaigns/{$campaign->id}/coaches/{$coach->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('representatives', [
            'representative_id'   => $coach->id,
            'representative_type' => Coach::class,
            'campaign_id'         => $campaign->id,
        ]);

        $this->assertCount(0, $campaign->fresh()->coaches);
    }
}
