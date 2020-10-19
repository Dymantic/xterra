<?php


namespace Tests\Feature\Media;


use App\Media\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeleteGalleryImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function delete_an_image_from_a_gallery()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $gallery = factory(Gallery::class)->create();
        $image = $gallery->addImage(UploadedFile::fake()->image('testpic.png'));

        $response = $this->asAdmin()->deleteJson("/admin/galleries/{$gallery->id}/images/{$image->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('media', ['id' => $image->id]);
    }

    /**
     * @test
     */
    public function cannot_delete_image_from_other_gallery()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $galleryA = factory(Gallery::class)->create();
        $galleryB = factory(Gallery::class)->create();
        $image = $galleryA->addImage(UploadedFile::fake()->image('testpic.png'));

        $response = $this
            ->asAdmin()
            ->deleteJson("/admin/galleries/{$galleryB->id}/images/{$image->id}");
        $response->assertForbidden();

        $this->assertDatabaseHas('media', ['id' => $image->id]);
    }
}
