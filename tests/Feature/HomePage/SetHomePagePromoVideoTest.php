<?php


namespace Tests\Feature\HomePage;


use App\HomePage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class SetHomePagePromoVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_the_promo_video_for_the_home_page()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/home-page/promo-video", [
            'video_id' => 'test_video_id',
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('embeddable_videos', [
            'video_id' => 'test_video_id',
            'title' => json_encode(['en' => 'test title', 'zh' => 'zh test title']),
        ]);

        $this->assertSame('test_video_id', HomePage::current()->promoVideo->getVideoId());
    }

    /**
     *@test
     */
    public function the_video_id_is_required()
    {
        $response = $this->asAdmin()->postJson("/admin/home-page/promo-video", [
            'video_id' => null,
            'title' => ['en' => 'test title', 'zh' => 'zh test title'],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('video_id');
    }

    /**
     *@test
     */
    public function the_title_must_be_a_translation()
    {
        $response = $this->asAdmin()->postJson("/admin/home-page/promo-video", [
            'video_id' => 'test_video_id',
            'title' => 'not-a-translation',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors('title');
    }
}
