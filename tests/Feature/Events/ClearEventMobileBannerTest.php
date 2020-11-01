<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ClearEventMobileBannerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_an_existing_mobile_banner_image()
    {
        $this->fakeMediaStorage();
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $image = $event->setMobileBanner(UploadedFile::fake()->image('test.png'));

        $response = $this->asAdmin()->deleteJson("/admin/events/{$event->id}/mobile-banner");
        $response->assertSuccessful();

        $this->assertCount(0, $event->fresh()->getMedia(Event::MOBILE_BANNER));
        $this->assertMediaStorageMissing($image);
    }
}
