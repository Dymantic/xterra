<?php

namespace App\Http\Controllers\Admin;

use App\HomePage;
use App\Http\Controllers\Controller;
use App\Occasions\Event;
use Illuminate\Http\Request;

class HomePageFeaturedEventController extends Controller
{
    public function store()
    {
        request()->validate([
            'event_id' => ['exists:events,id'],
        ]);

        HomePage::current()->featureEvent(Event::find(request('event_id')));
    }
}
