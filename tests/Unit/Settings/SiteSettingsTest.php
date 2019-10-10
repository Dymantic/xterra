<?php

namespace Tests\Unit\Settings;

use App\Settings\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteSettingsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function save_setting_and_value_into_site_settings()
    {
        SiteSetting::saveSetting('test_setting', 8);

        $this->assertEquals(8, SiteSetting::getSetting('test_setting'));
    }

    /**
     *@test
     */
    public function settings_can_be_retrieved_with_default_value()
    {
        $this->assertDatabaseMissing('site_settings', [
            'settings->test_setting' => 5,
        ]);

        $this->assertEquals(5, SiteSetting::getSetting('test_setting', 5));
    }
}