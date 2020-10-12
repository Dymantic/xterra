<?php


namespace Tests\Feature\Campaigns;


use App\Campaigns\Campaign;
use App\Media\BannerVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadBannerVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_video_for_campaign_banner()
    {
        Storage::fake(BannerVideo::DISK_NAME);
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/banner-video", [
            'video' => UploadedFile::fake()->create('video.mp4'),
        ]);
        $response->assertSuccessful();

        Storage::disk(BannerVideo::DISK_NAME)
               ->assertExists($campaign->fresh()->bannerVideo->filename);

    }

    /**
     *@test
     */
    public function the_video_is_required_and_must_be_a_valid_video_file()
    {
        Storage::fake(BannerVideo::DISK_NAME);

        $campaign = factory(Campaign::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/banner-video", [
            'video' => 'not-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('video');

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/banner-video", [
            'video' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('video');

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/banner-video", [
            'video' => UploadedFile::fake()->image('not-video.png'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('video');
    }
}
