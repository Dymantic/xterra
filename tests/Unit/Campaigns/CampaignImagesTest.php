<?php


namespace Tests\Unit\Campaigns;


use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;
use Tests\TestCase;

class CampaignImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_set_title_image_for_campaign()
    {
        Storage::fake('media');

        $campaign = factory(Campaign::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');

        $image = $campaign->setTitleImage($upload);

        $this->assertInstanceOf(Media::class, $image);
        $this->assertSame($upload->hashName(), $image->file_name);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));
        $this->assertTrue($image->fresh()->hasGeneratedConversion('thumb'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl('thumb'), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), '/media'));

    }

    /**
     *@test
     */
    public function can_clear_the_title_image()
    {
        Storage::fake('media');

        $campaign = factory(Campaign::class)->create();
        $image = $campaign->setTitleImage(UploadedFile::fake()->image('testpic.png'));

        $campaign->clearTitleImage();

        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), '/media'));
    }

    /**
     *@test
     */
    public function setting_a_title_image_overwrites_any_previous_ones()
    {
        Storage::fake('media');

        $campaign = factory(Campaign::class)->create();
        $old_image = $campaign->setTitleImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertCount(1, $campaign->fresh()->getMedia(Campaign::TITLE_IMAGE));

        $new_image = $campaign->setTitleImage(UploadedFile::fake()->image('test_pic.jpg'));

        $this->assertCount(1, $campaign->fresh()->getMedia(Campaign::TITLE_IMAGE));

        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), '/media'));
        Storage::disk('media')->assertExists(Str::after($new_image->getUrl(), '/media'));


    }

    /**
     *@test
     */
    public function can_store_images_for_the_campaign_narrative()
    {
        Storage::fake('media');

        $campaign = factory(Campaign::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');

        $image = $campaign->setNarrativeImage($upload);

        $this->assertInstanceOf(Media::class, $image);
        $this->assertSame($upload->hashName(), $image->file_name);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), '/media'));
    }
}
