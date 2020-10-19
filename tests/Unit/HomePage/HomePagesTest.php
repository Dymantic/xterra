<?php

namespace Tests\Unit\HomePage;

use App\Campaigns\Campaign;
use App\HomePage;
use App\Occasions\Event;
use App\Shop\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class HomePagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_set_the_banner_image()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $upload = UploadedFile::fake()->image('test.png');

        $image = HomePage::current()->setBannerImage($upload);

        $this->assertTrue(HomePage::current()->getFirstMedia(HomePage::BANNER_IMG)->is($image));
        $this->assertStringContainsString($upload->hashName(), $image->file_name);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('full'));
        $this->assertTrue($image->fresh()->hasGeneratedConversion('small'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl('full'), "/media"));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('small'), "/media"));
    }

    /**
     *@test
     */
    public function can_clear_the_banner_image()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $image = HomePage::current()->setBannerImage(UploadedFile::fake()->image('test.png'));

        HomePage::current()->clearBannerImage();

        $this->assertCount(0, HomePage::current()->getMedia(HomePage::BANNER_IMG));

        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function setting_banner_image_overwrites_previous_ones()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $old_image = HomePage::current()->setBannerImage(UploadedFile::fake()->image('test.png'));
        $this->assertCount(1, HomePage::current()->getMedia(HomePage::BANNER_IMG));

        $new_image = HomePage::current()->setBannerImage(UploadedFile::fake()->image('test2.png'));
        $this->assertCount(1, HomePage::current()->getMedia(HomePage::BANNER_IMG));

        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), "/media"));
        Storage::disk('media')->assertExists(Str::after($new_image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function can_feature_a_promotion()
    {
        $promo = factory(Promotion::class)->create();

        HomePage::current()->featurePromotion($promo);

        $this->assertTrue(HomePage::current()->promotion->is($promo));
    }

    /**
     *@test
     */
    public function can_feature_an_event()
    {
        $event = factory(Event::class)->create();

        HomePage::current()->featureEvent($event);

        $this->assertTrue(HomePage::current()->event->is($event));
    }

    /**
     *@test
     */
    public function can_feature_a_campaign()
    {
        $campaign = factory(Campaign::class)->create();

        HomePage::current()->featureCampaign($campaign);

        $this->assertTrue(HomePage::current()->campaign->is($campaign));
    }
}
