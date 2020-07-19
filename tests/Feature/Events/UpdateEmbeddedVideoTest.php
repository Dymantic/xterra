<?php


namespace Tests\Feature\Events;


use App\Media\EmbeddableVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateEmbeddedVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_the_title_of_an_existing_embeddable_video()
    {
        $this->withoutExceptionHandling();

        $video = factory(EmbeddableVideo::class)->state('youtube')->create();

        $response = $this->asAdmin()->postJson("/admin/embeddable-videos/{$video->id}", [
            'title' => ['en' => "new title", 'zh' => "zh new title"],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('embeddable_videos', [
            'id'           => $video->id,
            'title'        => json_encode(['en' => "new title", 'zh' => "zh new title"]),
            'platform'     => EmbeddableVideo::YOUTUBE,
            'video_id'     => $video->video_id,
            'videoed_id'   => $video->videoed_id,
            'videoed_type' => $video->videoed_type,
        ]);
    }

    /**
     *@test
     */
    public function the_title_is_required_in_at_least_one_language()
    {
        $video = factory(EmbeddableVideo::class)->state('youtube')->create();

        $response = $this->asAdmin()->postJson("/admin/embeddable-videos/{$video->id}", [
            'title' => [],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('title');
    }
}
