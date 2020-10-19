<?php


namespace Tests\Unit\Media;


use App\Media\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class GalleryImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function add_image_to_gallery()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $gallery = factory(Gallery::class)->create();

        $image = $gallery->addImage(UploadedFile::fake()->image('testpic.jpg'));

        $this->assertCount(1, $gallery->getMedia(Gallery::IMAGES));
        $this->assertTrue($gallery->getFirstMedia(Gallery::IMAGES)->is($image));

        $this->assertInstanceOf(Media::class, $image);
        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('thumb'));
        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl('thumb'), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), '/media'));
    }

    /**
     *@test
     */
    public function order_gallery_images()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $gallery = factory(Gallery::class)->create();

        $imageA = $gallery->addImage(UploadedFile::fake()->image('testpic.jpg'));
        $imageB = $gallery->addImage(UploadedFile::fake()->image('testpic.jpg'));
        $imageC = $gallery->addImage(UploadedFile::fake()->image('testpic.jpg'));
        $imageD = $gallery->addImage(UploadedFile::fake()->image('testpic.jpg'));

        $gallery->setOrder([$imageB->id, $imageD->id, $imageA->id, $imageC->id]);

        $this->assertSame(0, $imageB->fresh()->getCustomProperty('position'));
        $this->assertSame(1, $imageD->fresh()->getCustomProperty('position'));
        $this->assertSame(2, $imageA->fresh()->getCustomProperty('position'));
        $this->assertSame(3, $imageC->fresh()->getCustomProperty('position'));
    }
}
