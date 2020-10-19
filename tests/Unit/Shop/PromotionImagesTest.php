<?php


namespace Tests\Unit\Shop;


use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class PromotionImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_image_for_a_promotion()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $promotion = factory(Promotion::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');

        $image = $promotion->setImage($upload);

        $this->assertInstanceOf(Media::class, $image);
        $this->assertStringContainsString($upload->hashName(), $image->getPath());

        $image->refresh();

        $this->assertTrue($image->hasGeneratedConversion('thumb'));
        $this->assertTrue($image->hasGeneratedConversion('web'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('thumb'), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), '/media'));
    }

    /**
     *@test
     */
    public function can_clear_a_promotion_image()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $promotion = factory(Promotion::class)->create();
        $old_image = $promotion->setImage(UploadedFile::fake()->image('test_one.jpg'));

        $promotion->clearImage();

        $this->assertCount(0, $promotion->getMedia(Promotion::IMAGE));

        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), '/media'));
    }

    /**
     *@test
     */
    public function setting_an_image_overwrites_the_previous_image()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $promotion = factory(Promotion::class)->create();

        $old_image = $promotion->setImage(UploadedFile::fake()->image('test_one.jpg'));
        $new_image = $promotion->setImage(UploadedFile::fake()->image('test_two.jpg'));

        $this->assertCount(1, $promotion->getMedia(Promotion::IMAGE));

        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), '/media'));
        Storage::disk('media')->assertExists(Str::after($new_image->getUrl(), '/media'));
    }
}
