<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use Illuminate\Http\Request;

class RaceAthleteGuideController extends Controller
{
    public function store(Activity $race)
    {
        request()->validate([
            'athlete_guide' => ['file'],
        ]);

        $race->setAthleteGuide(request('athlete_guide'));
    }

    public function destroy(Activity $race)
    {
        $race->clearAthleteGuide();
    }
}
