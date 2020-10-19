<?php


namespace Tests\Unit\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class EventImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_set_banner_image_for_event()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $event = factory(Event::class)->create();
        $upload = UploadedFile::fake()->image('test.jpeg');

        $image = $event->setBannerImage($upload);

        $this->assertTrue($event->fresh()->getFirstMedia(Event::BANNER_IMAGE)->is($image));
        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('banner'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('banner'), "/media"));

    }

    /**
     *@test
     */
    public function can_clear_the_banner_image()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $event = factory(Event::class)->create();
        $image = $event->setBannerImage(UploadedFile::fake()->image('test.jpeg'));

        $event->clearBannerImage();

        $this->assertCount(0, $event->fresh()->getMedia(Event::BANNER_IMAGE));
        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function setting_banner_image_clears_previous_images()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $event = factory(Event::class)->create();
        $old_image = $event->setBannerImage(UploadedFile::fake()->image('test.jpeg'));
        $this->assertCount(1, $event->fresh()->getMedia(Event::BANNER_IMAGE));

        $new_image = $event->setBannerImage(UploadedFile::fake()->image('test_pic.png'));
        $this->assertCount(1, $event->fresh()->getMedia(Event::BANNER_IMAGE));

        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), "/media"));
        Storage::disk('media')->assertExists(Str::after($new_image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function can_set_card_image_for_an_event()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $event = factory(Event::class)->create();
        $upload = UploadedFile::fake()->image('test.jpeg');

        $image = $event->setCardImage($upload);

        $this->assertTrue($event->fresh()->getFirstMedia(Event::CARD_IMAGE)->is($image));
        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), "/media"));
    }

    /**
     *@test
     */
    public function can_clear_the_card_image()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $event = factory(Event::class)->create();
        $image = $event->setCardImage(UploadedFile::fake()->image('test.jpeg'));

        $event->clearCardImage();

        $this->assertCount(0, $event->fresh()->getMedia(Event::CARD_IMAGE));
        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function setting_card_image_clears_any_previous_images()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $event = factory(Event::class)->create();
        $old_image = $event->setCardImage(UploadedFile::fake()->image('test.jpeg'));
        $this->assertCount(1, $event->fresh()->getMedia(Event::CARD_IMAGE));

        $new_image = $event->setCardImage(UploadedFile::fake()->image('test_pic.png'));
        $this->assertCount(1, $event->fresh()->getMedia(Event::CARD_IMAGE));

        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), "/media"));
        Storage::disk('media')->assertExists(Str::after($new_image->getUrl(), "/media"));
    }
}
