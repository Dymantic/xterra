<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use App\Occasions\GeneralEventInfo;
use Illuminate\Http\Request;

class EventGeneralInfoController extends Controller
{
    public function update(Event $event)
    {
        request()->validate([
            'name.en' => ['required_without:name.zh'],
            'name.zh' => ['required_without:name.en'],
            'venue_maplink' => ['url', 'nullable'],
            'registration_link' => ['url', 'nullable'],
            'start' => ['date', 'nullable'],
            'end' => ['date', 'nullable'],
        ]);

        $event->updateGeneralInfo(new GeneralEventInfo(request()->all()));
    }
}
