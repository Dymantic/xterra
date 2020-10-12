<?php


namespace Tests\Feature\HomePage;


use App\HomePage;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClearHomePagePromoVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function clear_existing_promo_video_from_homepage()
    {
        $this->withoutExceptionHandling();
        $promo_video = HomePage::current()
                               ->setPromoVideo('test_video_id', new Translation([
                                   'en' => "test title", 'zh' => "zh test title"
                               ]));

        $response = $this->asAdmin()->deleteJson("/admin/home-page/promo-video");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('promo_videos', ['id' => $promo_video->id]);

        $this->assertNull(HomePage::current()->promo_video_id);
    }
}
