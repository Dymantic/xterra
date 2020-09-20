<?php


namespace Tests\Unit\Events;


use App\Media\Gallery;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventGalleriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function add_gallery_to_event()
    {
        $event = factory(Event::class)->create();
        $gallery = factory(Gallery::class)->create();

        $event->addGallery($gallery->id);

        $this->assertTrue($event->fresh()->galleries->contains($gallery));
    }

    /**
     *@test
     */
    public function remove_gallery_from_event()
    {
        $event = factory(Event::class)->create();
        $gallery = factory(Gallery::class)->create();
        $event->addGallery($gallery->id);

        $event->removeGallery($gallery->id);

        $this->assertFalse($event->fresh()->galleries->contains($gallery));
    }
}
