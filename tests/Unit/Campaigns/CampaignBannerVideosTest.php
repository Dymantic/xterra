<?php


namespace Tests\Unit\Campaigns;


use App\Campaigns\Campaign;
use App\Media\BannerVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CampaignBannerVideosTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_set_a_banner_video_on_a_campaign()
    {
        Storage::fake(BannerVideo::DISK_NAME);

        $campaign = factory(Campaign::class)->create();
        $upload = UploadedFile::fake()->create('video.mp4');

        $video = $campaign->setBannerVideo($upload);

        $this->assertSame(Campaign::class, $video->bannerable_type);
        $this->assertSame($campaign->id, $video->bannerable_id);
        $this->assertSame(BannerVideo::DISK_NAME, $video->disk);
        $this->assertSame($upload->hashName('banner_videos'), $video->filename);

        Storage::disk(BannerVideo::DISK_NAME)->assertExists($video->filename);
    }
}
