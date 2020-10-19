<?php

namespace Tests\Feature\HomePage;

use App\HomePage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadBannerImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_the_banner_image_for_the_homepage()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/home-page/banner-image", [
            'image' => UploadedFile::fake()->image('test.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, HomePage::current()->getMedia(HomePage::BANNER_IMG));
        $image = HomePage::current()->getFirstMedia(HomePage::BANNER_IMG);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function the_image_is_required_to_be_an_image_file()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $response = $this->asAdmin()->postJson("/admin/home-page/banner-image", [
            'image' => 'null',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/home-page/banner-image", [
            'image' => 'not-even-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/home-page/banner-image", [
            'image' => UploadedFile::fake()->create('not-an-image.txt'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
