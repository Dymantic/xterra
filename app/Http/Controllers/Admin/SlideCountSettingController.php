<?php

namespace App\Http\Controllers\Admin;

use App\Settings\SiteSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlideCountSettingController extends Controller
{

    public function show()
    {
        return ['slide_count' => SiteSetting::getSetting('slide_count', 6)];
    }

    public function update()
    {
        SiteSetting::saveSetting('slide_count', request('slide_count'));

        return ['slide_count' => SiteSetting::getSetting('slide_count', 6)];
    }
}
