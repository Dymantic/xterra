<?php

namespace App\Http\Controllers;

use App\Occasions\Activity;
use App\Occasions\ActivityPresenter;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    public function show(Activity $activity)
    {
        return view('front.activities.show', ['activity' => ActivityPresenter::forPublic($activity, app()->getLocale())]);
    }
}
