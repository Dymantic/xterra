<?php


namespace Tests\Feature\Events;


use App\Media\EmbeddableVideo;
use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AttachPromoVideoToActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function attach_promo_video_to_race()
    {
        $this->withoutExceptionHandling();
        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/promo-video", [
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
            'video_id' => 'test_video_id',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('embeddable_videos', [
            'title'        => json_encode(['en' => "test title", 'zh' => "zh test title"]),
            'videoed_id'   => $race->id,
            'videoed_type' => Activity::class,
            'platform'     => EmbeddableVideo::YOUTUBE,
        ]);
    }

    /**
     *@test
     */
    public function the_video_title_must_be_a_translation_array()
    {
        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/promo-video", [
            'title' => 'not-even-an-array',
            'video_id' => 'test_video_id',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('title');
    }

    /**
     *@test
     */
    public function the_video_id_is_required()
    {
        $race = factory(Activity::class)->state('race')->create();

        $response = $this->asAdmin()->postJson("/admin/races/{$race->id}/promo-video", [
            'title' => ['en' => "test title", 'zh' => "zh test title"],
            'video_id' => '',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('video_id');
    }
}
