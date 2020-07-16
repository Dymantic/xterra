<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventTravelGuideController extends Controller
{
    public function store(Event $event)
    {
        request()->validate([
            'travel_guide' => ['required', 'file', 'mimes:pdf,doc,docx']
        ]);

        $event->setTravelGuide(request('travel_guide'));
    }

    public function destroy(Event $event)
    {
        $event->clearTravelGuide();
    }
}
