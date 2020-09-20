<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetCampaignEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function set_the_event_for_a_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/event", [
            'event_id' => $event->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('campaigns', [
            'id'       => $campaign->id,
            'event_id' => $event->id,
        ]);
    }
}
