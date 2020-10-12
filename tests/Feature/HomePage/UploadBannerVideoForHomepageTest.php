<?php


namespace Tests\Feature\HomePage;


use App\HomePage;
use App\Media\BannerVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadBannerVideoForHomepageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_banner_video_for_home_page()
    {
        Storage::fake(BannerVideo::DISK_NAME);
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/home-page/banner-video", [
            'video' => UploadedFile::fake()->create('video.mp4'),
        ]);
        $response->assertSuccessful();

        Storage::disk(BannerVideo::DISK_NAME)
               ->assertExists(HomePage::current()->bannerVideo->filename);
    }

    /**
     *@test
     */
    public function the_banner_video_must_be_a_valid_video_file()
    {
        Storage::fake(BannerVideo::DISK_NAME);

        $response = $this->asAdmin()->postJson("/admin/home-page/banner-video", [
            'video' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('video');

        $response = $this->asAdmin()->postJson("/admin/home-page/banner-video", [
            'video' => 'not-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('video');

        $response = $this->asAdmin()->postJson("/admin/home-page/banner-video", [
            'video' => UploadedFile::fake()->create('not-a-video.txt'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('video');
    }
}
