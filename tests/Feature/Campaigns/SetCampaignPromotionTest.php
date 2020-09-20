<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetCampaignPromotionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_the_promotion_for_a_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $promo = factory(Promotion::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/promotion", [
            'promotion_id'=> $promo->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'promotion_id' => $promo->id,
        ]);
    }
}
