<?php


namespace Tests\Feature\People;


use App\Media\EmbeddableVideo;
use App\People\Ambassador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachAmbassadorYoutubeVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function attach_a_youtube_video_to_an_ambassador()
    {
        $this->withoutExceptionHandling();

        $ambassador = factory(Ambassador::class)->create();

        $response = $this->asAdmin()->postJson("/admin/ambassadors/{$ambassador->id}/youtube-videos", [
            'video_id' => 'test_video_id',
            'title'    => ['en' => "test title", 'zh' => "zh test title"],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('embeddable_videos', [
            'videoed_id'   => $ambassador->id,
            'videoed_type' => Ambassador::class,
            'title'        => json_encode(['en' => "test title", 'zh' => "zh test title"]),
            'video_id'     => 'test_video_id',
            'platform'     => EmbeddableVideo::YOUTUBE,
        ]);
    }

    /**
     *@test
     */
    public function the_video_title_is_required_in_at_least_one_language()
    {
        $ambassador = factory(Ambassador::class)->create();

        $response = $this->asAdmin()->postJson("/admin/ambassadors/{$ambassador->id}/youtube-videos", [
            'video_id' => 'test_video_id',
            'title'    => [],
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('title');
    }

    /**
     *@test
     */
    public function the_video_id_is_required()
    {
        $ambassador = factory(Ambassador::class)->create();

        $response = $this->asAdmin()->postJson("/admin/ambassadors/{$ambassador->id}/youtube-videos", [
            'video_id' => null,
            'title'    => ['en' => "test title", 'zh' => "zh test title"],
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('video_id');
    }
}
