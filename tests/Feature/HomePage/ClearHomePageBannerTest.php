<?php


namespace Tests\Feature\HomePage;


use App\HomePage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ClearHomePageBannerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_the_existing_homepage_banner()
    {
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $image = HomePage::current()->setBannerImage(UploadedFile::fake()->image('test.png'));

        $response = $this->asAdmin()->deleteJson("/admin/home-page/banner-image");
        $response->assertSuccessful();

        $this->assertCount(0, HomePage::current()->getMedia(HomePage::BANNER_IMG));
        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));
    }
}
