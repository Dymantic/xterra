<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventActivitiesController extends Controller
{
    public function store(Event $event, ActivityRequest $request)
    {
        $event->addActivity($request->activityInfo());
    }

    public function update(Activity $activity, ActivityRequest $request)
    {
        $activity->update($request->activityInfo()->toArray());
    }

    public function delete(Activity $activity)
    {
        $activity->delete();
    }
}
