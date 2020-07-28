<?php


namespace Tests\Feature\People;


use App\People\Coach;
use App\People\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClearCoachProfilePicTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_a_coaches_profile_pic()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media');

        $coach = factory(Coach::class)->create();
        $image = $coach->setProfilePic(UploadedFile::fake()->image('testpic.png'));

        $response = $this->asAdmin()->deleteJson("/admin/coaches/{$coach->id}/profile-pic");
        $response->assertSuccessful();

        $this->assertCount(0, $coach->fresh()->getMedia(Profile::AVATAR));

        $this->assertDatabaseMissing('media', ['id' => $image->id]);
    }
}
