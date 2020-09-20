<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ClearEventBannerImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_an_uploaded_banner_image_from_event()
    {
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $image = $event->setBannerImage(UploadedFile::fake()->image('test.jpg'));

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}/banner-image");
        $response->assertSuccessful();

        $this->assertCount(0, $event->fresh()->getMedia(Event::BANNER_IMAGE));
        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));


    }
}
