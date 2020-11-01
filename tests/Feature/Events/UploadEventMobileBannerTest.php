<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadEventMobileBannerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function upload_the_mobile_banner_for_an_event()
    {
        $this->fakeMediaStorage();
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/mobile-banner", [
            'image' => UploadedFile::fake()->image('test.png'),
        ]);
        $response->assertSuccessful();

        $this->assertCount(1, $event->getMedia(Event::MOBILE_BANNER));
        $image = $event->getFirstMedia(Event::MOBILE_BANNER);

        $this->assertMediaStorageHas($image);
    }

    /**
     *@test
     */
    public function the_image_is_required_as_a_recognized_image_file()
    {
        $this->fakeMediaStorage();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/mobile-banner", [
            'image' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/mobile-banner", [
            'image' => 'not-a-file',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/mobile-banner", [
            'image' => UploadedFile::fake()->create('not-image.txt'),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('image');
    }
}
