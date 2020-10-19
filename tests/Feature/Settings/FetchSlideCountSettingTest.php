<?php


namespace Tests\Feature\Settings;


use App\Settings\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchSlideCountSettingTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_current_slide_count_setting()
    {
        $this->withoutExceptionHandling();

        SiteSetting::saveSetting('slide_count', 6);

        $response = $this->asAdmin()->getJson("/admin/site-settings/slide-count");
        $response->assertStatus(200);

        $this->assertEquals(6, $response->json('slide_count'));
    }
}
