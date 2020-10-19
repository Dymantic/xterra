<?php


namespace Tests\Feature\People;


use App\People\Coach;
use App\People\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadCoachProfilePicTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_coach_profile_picture()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media', config('filesystems.disks.media'));

        $coach = factory(Coach::class)->create();
        $upload = UploadedFile::fake()->image('testpic.png');

        $response = $this->asAdmin()->postJson("/admin/coaches/{$coach->id}/profile-pic", [
            'image' => $upload,
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $coach->fresh()->getMedia(Profile::AVATAR));

        Storage::disk('media')->assertExists(
            Str::after($coach->getFirstMedia(Profile::AVATAR)->getUrl(), '/media')
        );
    }

    /**
     *@test
     */
    public function the_image_is_required()
    {
        $this->assertUploadIsInvalid(null);
    }

    /**
     *@test
     */
    public function the_upload_must_be_a_valid_image_file()
    {
        $this->assertUploadIsInvalid('not-even-a-file');
        $this->assertUploadIsInvalid(UploadedFile::fake()->create('not-a-pic.docx'));
    }

    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $coach = factory(Coach::class)->create();

        $response = $this->asAdmin()->postJson("/admin/coaches/{$coach->id}/profile-pic", [
            'image' => $upload,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
