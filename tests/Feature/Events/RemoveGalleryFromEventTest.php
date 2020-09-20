<?php


namespace Tests\Feature\Events;


use App\Media\Gallery;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveGalleryFromEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_a_gallery_from_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $gallery = factory(Gallery::class)->create();
        $event->addGallery($gallery->id);

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}/galleries/{$gallery->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('event_gallery', [
            'event_id' => $event->id,
            'gallery_id' => $gallery->id,
        ]);

        $this->assertFalse($event->fresh()->galleries->contains($gallery));
    }
}
