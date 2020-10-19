<?php


namespace Tests\Feature\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadActivityContentImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_a_content_image_to_an_activity()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/content-images", [
            'image' => UploadedFile::fake()->image('testpic.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $race->getMedia(Activity::CONTENT_IMAGES));
        $image = $race->getFirstMedia(Activity::CONTENT_IMAGES);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));

        $this->assertSame($image->getUrl(), $response->json('file.url'));
        $this->assertSame(1, $response->json('success'));
    }

    /**
     *@test
     */
    public function the_image_must_be_a_valid_image_file()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/content-images", [
            'image' => UploadedFile::fake()->create('not-a-image.txt'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/content-images", [
            'image' => 'not-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
