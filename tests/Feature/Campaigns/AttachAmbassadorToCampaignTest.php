<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\People\Ambassador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachAmbassadorToCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function add_an_ambassador_to_a_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $ambassador = factory(Ambassador::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/ambassadors", [
            'ambassador_id' => $ambassador->id,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('representatives', [
            'representative_id'   => $ambassador->id,
            'representative_type' => Ambassador::class,
            'campaign_id'         => $campaign->id,
        ]);

        $this->assertCount(1, $campaign->fresh()->ambassadors);
    }

    /**
     *@test
     */
    public function the_ambassador_id_must_exist_in_the_ambassador_table()
    {
        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/ambassadors", [
            'ambassador_id' => 99,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('ambassador_id');
    }

    /**
     *@test
     */
    public function the_ambassador_cannot_already_be_attached_to_the_campaign()
    {
        $campaign = factory(Campaign::class)->create();
        $ambassador = factory(Ambassador::class)->create();
        $campaign->ambassadors()->attach($ambassador->id);

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/ambassadors", [
            'ambassador_id' => $ambassador->id,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('ambassador_id');
    }
}
