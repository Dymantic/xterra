<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadRaceCardImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_the_card_image_for_a_race()
    {
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/card-image", [
            'image' => UploadedFile::fake()->image('test.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $race->getMedia(Activity::CARD_IMAGE));
        $image = $race->getFirstMedia(Activity::CARD_IMAGE);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function the_image_must_be_a_valid_image_file()
    {
        Storage::fake('media');

        $race = factory(Activity::class)->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/card-image", [
            'image' => UploadedFile::fake()->create('not-image.doc'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/card-image", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
