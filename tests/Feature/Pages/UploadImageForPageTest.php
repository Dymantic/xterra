<?php


namespace Tests\Feature\Pages;


use App\Pages\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadImageForPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_an_image_for_a_page()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media');

        $page = factory(Page::class)->create();

        $response = $this->asAdmin()->postJson("/admin/pages/{$page->id}/images", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $page->getMedia(Page::CONTENT_IMAGES));
        $image = $page->getFirstMedia();

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
    }
}
