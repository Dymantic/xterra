<?php


namespace Tests\Unit\People;


use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;
use Tests\TestCase;

class CoachProfilePicTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_set_profile_pic_for_coach()
    {
        Storage::fake('media');
        $coach = factory(Coach::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');

        $image = $coach->setProfilePic($upload);

        $this->assertTrue($image->fresh()->hasGeneratedConversion('thumb'));
        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));

        $this->assertInstanceOf(Media::class, $image);
        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
    }
}
