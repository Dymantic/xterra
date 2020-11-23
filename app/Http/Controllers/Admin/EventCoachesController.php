<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use App\People\Coach;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventCoachesController extends Controller
{
    public function store(Event $event)
    {
        request()->validate([
            'coach_id' => ['exists:coaches,id']
        ]);

        if($event->coaches->pluck('id')->contains(request('coach_id'))) {
            throw ValidationException::withMessages([
                'coach_id' => 'Coach is already attached to event',
            ]);
        }

        $event->coaches()->attach(request('coach_id'));
    }

    public function destroy(Event $event, Coach $coach)
    {
        $event->coaches()->detach($coach->id);
    }
}
