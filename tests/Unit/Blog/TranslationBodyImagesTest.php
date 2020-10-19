<?php


namespace Tests\Unit\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;
use Tests\TestsMediaAttachments;

class TranslationBodyImagesTest extends TestCase
{
    use RefreshDatabase, TestsMediaAttachments;

    /**
     *@test
     */
    public function attach_a_image()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $translation = factory(Translation::class)->create();
        $this->assertCount(0, $translation->getMedia(Translation::BODY_IMAGES));

        $image = $translation->attachImage(UploadedFile::fake()->image('test.png'));

        $this->assertInstanceOf(Media::class, $image);
        $this->assertCount(1, $translation->fresh()->getMedia(Translation::BODY_IMAGES));
        $this->assertDiskHasMediaImage('media', $image);
    }

    /**
     *@test
     */
    public function a_web_conversion_is_created()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $translation = factory(Translation::class)->create();

        $image = $translation->attachImage(UploadedFile::fake()->image('test.png'));
        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));

        $this->assertDiskHasMediaImageConversions('media', $image, collect(['web']));
    }
}
