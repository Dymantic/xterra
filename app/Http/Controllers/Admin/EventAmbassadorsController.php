<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use App\People\Ambassador;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventAmbassadorsController extends Controller
{
    public function store(Event $event)
    {
        request()->validate([
            'ambassador_id' => ['exists:ambassadors,id']
        ]);

        if($event->ambassadors->pluck('id')->contains(request('ambassador_id'))) {
            throw ValidationException::withMessages([
                'ambassador_id' => 'Ambassador already attached to event'
            ]);
        }

        $event->ambassadors()->attach(request('ambassador_id'));
    }

    public function destroy(Event $event, Ambassador $ambassador)
    {
        $event->ambassadors()->detach($ambassador->id);
    }
}
