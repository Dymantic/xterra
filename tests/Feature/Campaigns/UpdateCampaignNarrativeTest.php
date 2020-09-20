<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateCampaignNarrativeTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_the_narrative_for_a_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/narrative", [
            'narrative' => [
                'lang' => 'en',
                'content' => 'test narrative'
            ],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'narrative' => json_encode(['en' => 'test narrative', 'zh' => '']),
        ]);
    }

    /**
     *@test
     */
    public function the_narrative_must_have_an_acceptable_lang()
    {
        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/narrative", [
            'narrative' => [
                'content' => 'test narrative',
                'lang' => null
            ],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('narrative.lang');
    }
}
