<?php


namespace Tests\Feature\Events;


use App\Media\Gallery;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachGalleryToEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function attach_a_gallery_to_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $gallery = factory(Gallery::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/galleries", [
            'gallery_id' => $gallery->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('event_gallery', [
            'event_id' => $event->id,
            'gallery_id' => $gallery->id,
        ]);

        $this->assertTrue($event->fresh()->galleries->contains($gallery));
    }

    /**
     *@test
     */
    public function the_gallery_id_is_required()
    {
        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/galleries", [
            'gallery_id' => null,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('gallery_id');
    }

    /**
     *@test
     */
    public function the_gallery_id_must_exist_in_galleries_table()
    {
        $this->assertNull(Gallery::find(99));
        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/galleries", [
            'gallery_id' => 99,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('gallery_id');
    }
}
