<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadRaceBannerImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_a_banner_image_for_a_race()
    {
        $this->withoutExceptionHandling();
        Storage::fake('media', config('filesystems.disks.media'));

        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/banner-image", [
            'image' => UploadedFile::fake()->image('test.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $race->getMedia(Activity::BANNER_IMAGE));
        $image = $race->getFirstMedia(Activity::BANNER_IMAGE);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function the_image_must_be_a_valid_image_file()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/banner-image", [
            'image' => UploadedFile::fake()->create('not-a-doc.txt'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/banner-image", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
