<?php


namespace Tests\Unit\People;


use App\People\Ambassador;
use App\People\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;
use Tests\TestCase;

class AmbassadorProfilePicsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function set_profile_pic_for_ambassador()
    {
        Storage::fake('media');

        $ambassador = factory(Ambassador::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');

        $image = $ambassador->setProfilePic($upload);

        $this->assertInstanceOf(Media::class, $image);
        $this->assertTrue($image->model->is($ambassador));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));

        $this->assertTrue($image->fresh()->hasGeneratedConversion('thumb'));
        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));

        Storage::disk('media')->assertExists(Str::after($image->getUrl('thumb'), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), '/media'));
    }

    /**
     *@test
     */
    public function uploading_second_image_overwrites_first()
    {
        Storage::fake('media');

        $ambassador = factory(Ambassador::class)->create();

        $old_image = $ambassador->setProfilePic(UploadedFile::fake()->image('testpic.png'));
        $new_image = $ambassador->setProfilePic(UploadedFile::fake()->image('test_pic.png'));

        $this->assertCount(1, $ambassador->getMedia(Profile::AVATAR));

        Storage::disk('media')->assertExists(Str::after($new_image->getUrl(), '/media'));
        Storage::disk('media')->assertExists(Str::after($new_image->getUrl('thumb'), '/media'));
        Storage::disk('media')->assertExists(Str::after($new_image->getUrl('web'), '/media'));

        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), '/media'));
        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl('thumb'), '/media'));
        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl('web'), '/media'));
    }

    /**
     *@test
     */
    public function clear_profile_picture()
    {
        Storage::fake('media');
        $ambassador = factory(Ambassador::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');
        $image = $ambassador->setProfilePic($upload);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('thumb'), '/media'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), '/media'));

        $ambassador->clearProfilePic();

        $this->assertCount(0, $ambassador->fresh()->getMedia(Profile::AVATAR));

        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), '/media'));
        Storage::disk('media')->assertMissing(Str::after($image->getUrl('thumb'), '/media'));
        Storage::disk('media')->assertMissing(Str::after($image->getUrl('web'), '/media'));
    }
}
