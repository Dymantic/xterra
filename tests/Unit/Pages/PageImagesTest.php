<?php


namespace Tests\Unit\Pages;


use App\Pages\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;
use Tests\TestCase;

class PageImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function save_image_for_a_given_page()
    {
        Storage::fake('media');

        $page = factory(Page::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');

        $image = $page->saveImage($upload);

        $this->assertInstanceOf(Media::class, $image);
        $this->assertTrue($image->model->is($page));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), '/media'));
    }
}
