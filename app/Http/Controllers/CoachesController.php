<?php

namespace App\Http\Controllers;

use App\People\Coach;
use App\People\CoachPresenter;
use Illuminate\Http\Request;

class CoachesController extends Controller
{
    public function show(Coach $coach)
    {
        return view('front.people.coach', [
            'coach' => CoachPresenter::forPublic($coach, app()->getLocale())
        ]);
    }
}
