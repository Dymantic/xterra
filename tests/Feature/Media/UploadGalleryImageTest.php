<?php


namespace Tests\Feature\Media;


use App\Media\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadGalleryImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function upload_an_image_to_a_gallery()
    {
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $gallery = factory(Gallery::class)->create();
        $this->assertCount(0, $gallery->getMedia(Gallery::IMAGES));


        $response = $this->asAdmin()->postJson("/admin/galleries/{$gallery->id}/images", [
            'image' => UploadedFile::fake()->image('testpic.png')
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $gallery->fresh()->getMedia(Gallery::IMAGES));
        $gallery_image_url = $gallery->fresh()->getFirstMedia(Gallery::IMAGES)->getUrl();

        Storage::disk('media')
               ->assertExists(Str::after($gallery_image_url, '/media'));
    }

    /**
     *@test
     */
    public function the_image_is_required()
    {
        $this->assertUploadIsInvalid(null);
    }

    /**
     *@test
     */
    public function the_image_must_be_a_valid_image_file()
    {
        $this->assertUploadIsInvalid('not-even-a-file');
        $this->assertUploadIsInvalid(UploadedFile::fake()->create('not-an-image.txt'));
    }

    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('media');

        $gallery = factory(Gallery::class)->create();

        $response = $this->asAdmin()->postJson("/admin/galleries/{$gallery->id}/images", [
            'image' => $upload
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
