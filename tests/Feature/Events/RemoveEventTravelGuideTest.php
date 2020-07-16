<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RemoveEventTravelGuideTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_the_travel_guide_from_an_event()
    {
        Storage::fake('admin_uploads');
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $event->setTravelGuide(UploadedFile::fake()->create('test_guide.pdf'));
        $filepath = $event->travel_guide;

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}/travel-guide");
        $response->assertSuccessful();

        Storage::disk('admin_uploads')->assertMissing($filepath);

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'travel_guide' => null,
            'travel_guide_disk' => null,
        ]);
    }
}
