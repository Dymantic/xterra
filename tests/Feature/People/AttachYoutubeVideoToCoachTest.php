<?php


namespace Tests\Feature\People;


use App\Media\EmbeddableVideo;
use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachYoutubeVideoToCoachTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function attach_a_video_to_a_coach()
    {
        $this->withoutExceptionHandling();

        $coach = factory(Coach::class)->create();

        $response = $this->asAdmin()->postJson("/admin/coaches/{$coach->id}/youtube-videos", [
            'title'    => ['en' => 'test title', 'zh' => 'zh test title'],
            'video_id' => 'test_video_id',
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('embeddable_videos', [
            'videoed_id'   => $coach->id,
            'videoed_type' => Coach::class,
            'title'        => json_encode(['en' => "test title", 'zh' => "zh test title"]),
            'video_id'     => 'test_video_id',
            'platform'     => EmbeddableVideo::YOUTUBE,
        ]);
    }

    /**
     *@test
     */
    public function the_video_id_is_required()
    {
        $coach = factory(Coach::class)->create();

        $response = $this->asAdmin()->postJson("/admin/coaches/{$coach->id}/youtube-videos", [
            'title'    => ['en' => 'test title', 'zh' => 'zh test title'],
            'video_id' => null,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('video_id');
    }

    /**
     *@test
     */
    public function the_title_is_required_in_at_least_one_language()
    {
        $coach = factory(Coach::class)->create();

        $response = $this->asAdmin()->postJson("/admin/coaches/{$coach->id}/youtube-videos", [
            'title'    => [],
            'video_id' => 'test_video_id',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('title');
    }
}
