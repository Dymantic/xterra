<?php

namespace Tests\Feature\Settings;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetSlideCountTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_set_a_maximum_number_of_slides()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/site-settings/slide-count", [
            'slide_count' => 6,
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('site_settings', [
            'settings->slide_count' => 6,
        ]);
        $this->assertEquals(6, $response->json('slide_count'));
    }
}
