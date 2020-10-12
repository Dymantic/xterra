<?php


namespace Tests\Feature\HomePage;


use App\HomePage;
use App\Media\BannerVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeleteHomePageBannerVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_existing_homepage_banner_video()
    {
        Storage::fake(BannerVideo::DISK_NAME);
        $this->withoutExceptionHandling();
        $video = HomePage::current()->setBannerVideo(UploadedFile::fake()->create('video.mp4'));

        $response = $this->asAdmin()->deleteJson("/admin/home-page/banner-video");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('banner_videos', ['id' => $video->id]);

        Storage::disk(BannerVideo::DISK_NAME)->assertMissing($video->filename);

    }
}
