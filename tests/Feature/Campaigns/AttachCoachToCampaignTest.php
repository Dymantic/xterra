<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachCoachToCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function add_a_coach_to_a_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $coach = factory(Coach::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/coaches", [
            'coach_id' => $coach->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('representatives', [
            'representative_id'   => $coach->id,
            'representative_type' => Coach::class,
            'campaign_id'         => $campaign->id,
        ]);
    }

    /**
     *@test
     */
    public function the_coach_id_must_exist_in_the_coach_table()
    {
        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/coaches", [
            'coach_id' => 99,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('coach_id');
    }

    /**
     *@test
     */
    public function the_coach_can_not_already_be_attached_to_the_campaign()
    {
        $campaign = factory(Campaign::class)->create();
        $coach = factory(Coach::class)->create();
        $campaign->coaches()->attach($coach->id);

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/coaches", [
            'coach_id' => $coach->id,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('coach_id');
    }
}
