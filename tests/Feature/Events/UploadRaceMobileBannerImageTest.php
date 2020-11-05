<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadRaceMobileBannerImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_the_mobile_banner_for_a_race()
    {
        $this->withoutExceptionHandling();
        $this->fakeMediaStorage();

        $race = factory(Activity::class)->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/mobile-banner", [
            'image' => UploadedFile::fake()->image('test.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $race->fresh()->getMedia(Activity::MOBILE_BANNER));
        $image = $race->fresh()->getFirstMedia(Activity::MOBILE_BANNER);

        $this->assertMediaStorageHas($image);
    }

    /**
     *@test
     */
    public function the_banner_is_required_as_a_valid_image_file()
    {
        $this->fakeMediaStorage();

        $race = factory(Activity::class)->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/mobile-banner", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/mobile-banner", [
            'image' => 'not-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/mobile-banner", [
            'image' => UploadedFile::fake()->create('not-an-image.docx'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
