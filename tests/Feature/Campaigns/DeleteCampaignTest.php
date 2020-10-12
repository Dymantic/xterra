<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_campaign()
    {
        $this->withoutExceptionHandling();
        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/campaigns/{$campaign->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('campaigns', ['id' => $campaign->id]);
    }
}
