<?php


namespace Tests\Unit\Events;


use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ActivityImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_add_a_mobile_banner_to_activity()
    {
        $this->fakeMediaStorage();

        $activity = factory(Activity::class)->create();
        $upload = UploadedFile::fake()->image('test.png');

        $image = $activity->setMobileBanner($upload);

        $this->assertTrue($activity->getFirstMedia(Activity::MOBILE_BANNER)->is($image));
        $this->assertStringContainsString($upload->hashName(), $image->file_name);
        $this->assertTrue($image->fresh()->hasGeneratedConversion('mobile_banner'));
        $this->assertMediaStorageHas($image, ['mobile_banner']);
    }

    /**
     *@test
     */
    public function can_clear_the_mobile_banner()
    {
        $this->fakeMediaStorage();

        $activity = factory(Activity::class)->create();
        $image = $activity->setMobileBanner(UploadedFile::fake()->image('test.png'));

        $activity->refresh();

        $activity->clearMobileBanner();
        $activity->refresh();

        $this->assertMediaStorageMissing($image);
        $this->assertCount(0, $activity->getMedia(Activity::MOBILE_BANNER));
    }

    /**
     *@test
     */
    public function setting_mobile_banner_clears_previous_ones()
    {
        $this->fakeMediaStorage();
        $activity = factory(Activity::class)->create();
        $old_image = $activity->setMobileBanner(UploadedFile::fake()->image('test.png'));
        $this->assertCount(1, $activity->fresh()->getMedia(Activity::MOBILE_BANNER));

        $new_image = $activity->setMobileBanner(UploadedFile::fake()->image('test2.png'));
        $this->assertCount(1, $activity->fresh()->getMedia(Activity::MOBILE_BANNER));

        $this->assertMediaStorageMissing($old_image);
        $this->assertMediaStorageHas($new_image);
    }
}
