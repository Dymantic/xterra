<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ClearEventCardImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_an_uploaded_event_card_image()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $image = $event->setCardImage(UploadedFile::fake()->image('test.jpg'));

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}/card-image");
        $response->assertSuccessful();

        $this->assertCount(0, $event->fresh()->getMedia(Event::CARD_IMAGE));
        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));
    }
}
