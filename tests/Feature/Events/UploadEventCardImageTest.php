<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadEventCardImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_the_card_image_for_an_event()
    {
        Storage::fake('disk');
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/card-image", [
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $event->getMedia(Event::CARD_IMAGE));
        $image = $event->getFirstMedia(Event::CARD_IMAGE);

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
    }

    /**
     *@test
     */
    public function the_image_must_be_an_actual_image_file()
    {
        Storage::fake('media', config('filesystems.disks.media'));

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/card-image", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/banner-image", [
            'image' => UploadedFile::fake()->create('not-image.docx'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
