<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\People\Coach;
use App\People\CoachPresenter;
use Illuminate\Http\Request;

class CoachPreviewController extends Controller
{
    public function show(Coach $coach)
    {
        $lang = request('lang', 'en');
        app()->setLocale($lang);

        return view('front.people.coach', ['coach' => CoachPresenter::forPublic($coach, $lang)]);
    }
}
