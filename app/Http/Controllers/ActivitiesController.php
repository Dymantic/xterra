<?php

namespace App\Http\Controllers;

use App\Occasions\Activity;
use App\Occasions\ActivityPresenter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActivitiesController extends Controller
{
    public function show(Activity $activity)
    {
        abort_if(!$activity->event->is_public && !auth()->check(), Response::HTTP_NOT_FOUND);

        return view('front.activities.show', [
            'activity' => ActivityPresenter::forPublic($activity, app()->getLocale())
        ]);
    }
}
