<?php


namespace Tests\Feature\Events;


use App\Media\EmbeddableVideo;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachYouTubeVideoToEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function attach_a_youtube_video_to_an_existing_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/youtube-videos", [
            'title'    => ['en' => "test title", 'zh' => "zh test title"],
            'video_id' => 'test-video-id'
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('embeddable_videos', [
            'title'        => json_encode(['en' => "test title", 'zh' => "zh test title"]),
            'videoed_id'   => $event->id,
            'platform'     => EmbeddableVideo::YOUTUBE,
            'videoed_type' => Event::class,
        ]);
    }

    /**
     * @test
     */
    public function the_title_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['title' => null]);
    }

    /**
     *@test
     */
    public function the_video_id_is_required()
    {
        $this->assertFieldIsInvalid(['video_id' => null]);
    }

    private function assertFieldIsInvalid($field)
    {
        $event = factory(Event::class)->create();

        $valid = [
            'title'    => ['en' => "test title", 'zh' => "zh test title"],
            'video_id' => 'test-video-id'
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/events/{$event->id}/youtube-videos", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
