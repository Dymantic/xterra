<?php


namespace Tests\Feature\HomePage;


use App\Campaigns\Campaign;
use App\HomePage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachCampaignToHomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function attach_an_existing_campaign_to_the_home_page()
    {
        $this->withoutExceptionHandling();
        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/home-page/featured-campaign", [
            'campaign_id' => $campaign->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('home_pages', [
            'id' => HomePage::current()->id,
            'campaign_id' => $campaign->id,
        ]);
    }

    /**
     *@test
     */
    public function the_campaign_id_must_exist_on_the_campaign_table()
    {
        $response = $this->asAdmin()->postJson("/admin/home-page/featured-campaign", [
            'campaign_id' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('campaign_id');

        $response = $this->asAdmin()->postJson("/admin/home-page/featured-campaign", [
            'campaign_id' => 9999,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('campaign_id');
    }
}
