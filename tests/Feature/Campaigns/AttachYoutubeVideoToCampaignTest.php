<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\Media\EmbeddableVideo;
use App\Media\PromoVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachYoutubeVideoToCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function attach_an_embeddable_youtube_video_to_campaign()
    {
        $this->withoutExceptionHandling();
        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/promo-video", [
            'title'    => ['en' => 'test title', 'zh' => 'zh test title'],
            'video_id' => 'test_video_id',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('embeddable_videos', [
            'title'        => json_encode(['en' => "test title", 'zh' => "zh test title"]),
            'video_id'     => 'test_video_id',
            'videoed_id'   => $campaign->fresh()->promoVideo->id,
            'videoed_type' => PromoVideo::class,
            'platform'     => EmbeddableVideo::YOUTUBE,
        ]);
    }

    /**
     * @test
     */
    public function the_video_id_is_required()
    {
        $this->assertFieldIsInvalid(['video_id' => null]);
    }

    /**
     * @test
     */
    public function the_video_title_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['title' => 'not-even-an-array']);
    }

    private function assertFieldIsInvalid($field)
    {
        $campaign = factory(Campaign::class)->create();
        $valid = [
            'title'    => ['en' => 'test title', 'zh' => 'zh test title'],
            'video_id' => 'test_video_id',
        ];
        $response = $this
            ->asAdmin()
            ->postJson("/admin/campaigns/{$campaign->id}/promo-video", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
