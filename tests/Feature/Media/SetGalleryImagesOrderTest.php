<?php


namespace Tests\Feature\Media;


use App\Media\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;
use Tests\TestCase;

class SetGalleryImagesOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_the_image_positions_for_gallery_images()
    {
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $gallery = factory(Gallery::class)->create();
        $imageA = $gallery->addImage(UploadedFile::fake()->image('testpic.jpg'));
        $imageB = $gallery->addImage(UploadedFile::fake()->image('testpic.jpg'));
        $imageC = $gallery->addImage(UploadedFile::fake()->image('testpic.jpg'));
        $imageD = $gallery->addImage(UploadedFile::fake()->image('testpic.jpg'));

        $response = $this->asAdmin()->postJson("/admin/galleries/{$gallery->id}/image-order", [
            'image_ids' => [$imageC->id, $imageB->id, $imageD->id, $imageA->id],
        ]);
        $response->assertSuccessful();

        $this->assertSame(0, $imageC->fresh()->getCustomProperty('position'));
        $this->assertSame(1, $imageB->fresh()->getCustomProperty('position'));
        $this->assertSame(2, $imageD->fresh()->getCustomProperty('position'));
        $this->assertSame(3, $imageA->fresh()->getCustomProperty('position'));
    }

    /**
     *@test
     */
    public function the_image_ids_are_required()
    {
        $this->assertImageIdsInvalid(null);
    }

    /**
     *@test
     */
    public function the_image_ids_must_be_an_array()
    {
        $this->assertImageIdsInvalid('not-an-array');
    }

    /**
     *@test
     */
    public function each_image_id_must_exist_in_the_media_table()
    {
        $this->assertNull(Media::find(99));

        $this->assertImageIdsInvalid([99], 'image_ids.0');
    }

    private function assertImageIdsInvalid($image_ids, $error_key = 'image_ids')
    {
        Storage::fake('media');

        $gallery = factory(Gallery::class)->create();

        $response = $this->asAdmin()->postJson("/admin/galleries/{$gallery->id}/image-order", [
            'image_ids' => $image_ids,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key);
    }
}
