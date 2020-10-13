<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\Media\BannerVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClearCampaignBannerVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_campaign_banner_video()
    {
        Storage::fake(BannerVideo::DISK_NAME);
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $video = $campaign->setBannerVideo(UploadedFile::fake()->create('video.mp4'));

        $response = $this->asAdmin()->deleteJson("/admin/campaigns/{$campaign->id}/banner-video");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('banner_videos', ['id' => $video->id]);
        $this->assertNull($campaign->fresh()->bannerVideo);

        Storage::disk(BannerVideo::DISK_NAME)->assertMissing($video->filename);
    }
}
