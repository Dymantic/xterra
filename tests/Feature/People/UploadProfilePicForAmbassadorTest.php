<?php


namespace Tests\Feature\People;


use App\People\Ambassador;
use App\People\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadProfilePicForAmbassadorTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_profile_pic_for_ambassador()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media');

        $ambassador = factory(Ambassador::class)->create();

        $response = $this->asAdmin()->postJson("/admin/ambassadors/{$ambassador->id}/profile-pic", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);

        $response->assertSuccessful();

        $this->assertCount(1, $ambassador->getMedia(Profile::AVATAR));
        $image = $ambassador->getFirstMedia(Profile::AVATAR);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), '/media'));
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
    public function the_image_must_be_a_valid_image_file()
    {
        $this->assertUploadIsInvalid('not-even-a-file');
        $this->assertUploadIsInvalid(UploadedFile::fake()->create('not-image.docx'));
    }

    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('media');

        $ambassador = factory(Ambassador::class)->create();

        $response = $this->asAdmin()->postJson("/admin/ambassadors/{$ambassador->id}/profile-pic", [
            'image' => $upload,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
