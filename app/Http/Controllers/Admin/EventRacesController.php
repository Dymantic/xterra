<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Occasions\Activity;
use App\Occasions\ActivityInfo;
use App\Occasions\Event;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventRacesController extends Controller
{
    public function store(Event $event, ActivityRequest $request)
    {
        $event->addRace($request->raceInfo());
    }

    public function update(Activity $race, ActivityRequest $request)
    {
        $race->update($request->raceInfo()->toArray());
    }

    public function delete(Activity $race)
    {
        $race->delete();
    }
}
