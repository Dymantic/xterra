<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadEventTravelGuideTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function upload_travel_document_for_event()
    {
        Storage::fake('admin_uploads');
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();
        $document = UploadedFile::fake()->create('test_doc.pdf');

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/travel-guide", [
            'travel_guide' => $document
        ]);
        $response->assertSuccessful();

        Storage::disk('admin_uploads')->assertExists($document->hashName('travel'));

        $this->assertDatabaseHas('events', [
            'id'              => $event->id,
            'travel_guide' => $document->hashName('travel'),
            'travel_guide_disk' => 'admin_uploads',
        ]);
    }

    /**
     *@test
     */
    public function the_travel_guide_is_required()
    {
        $this->assertUploadIsInvalid(['travel_guide' => null]);
    }

    /**
     *@test
     */
    public function the_guide_must_be_a_file()
    {
        $this->assertUploadIsInvalid(['travel_guide' => 'not-a-file']);
    }

    /**
     *@test
     */
    public function the_file_must_be_a_valid_document_type()
    {
        $this->assertUploadIsInvalid([
            'travel_guide' => UploadedFile::fake()->image('not-a-doc.png')
        ]);
    }

    private function assertUploadIsInvalid($upload)
    {
        Storage::fake('admin_uploads');

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/travel-guide", $upload);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('travel_guide');
    }
}
