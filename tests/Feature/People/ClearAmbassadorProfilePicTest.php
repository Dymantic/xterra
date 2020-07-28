<?php


namespace Tests\Feature\People;


use App\People\Ambassador;
use App\People\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClearAmbassadorProfilePicTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_an_existing_profile_pic_for_an_ambassador()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media');

        $ambassador = factory(Ambassador::class)->create();
        $image = $ambassador->setProfilePic(UploadedFile::fake()->image('testpic.png'));

        $response = $this->asAdmin()->deleteJson("/admin/ambassadors/{$ambassador->id}/profile-pic");
        $response->assertSuccessful();

        $this->assertCount(0, $ambassador->fresh()->getMedia(Profile::AVATAR));

        $this->assertDatabaseMissing('media', ['id' => $image->id]);
    }
}
