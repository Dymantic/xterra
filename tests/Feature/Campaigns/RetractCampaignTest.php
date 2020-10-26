<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetractCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function retract_a_campaign()
    {
        $this->withoutExceptionHandling();
        $campaign = factory(Campaign::class)->state('public')->create();

        $response = $this->asAdmin()->deleteJson("/admin/published-campaigns/{$campaign->id}");
        $response->assertSuccessful();

        $this->assertDatabaseHas('campaigns', [
            'id'        => $campaign->id,
            'is_public' => false,
        ]);
    }
}
