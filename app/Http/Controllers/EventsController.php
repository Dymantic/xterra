<?php

namespace App\Http\Controllers;

use App\Occasions\Event;
use App\Occasions\EventPresenter;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        return view('front.events.index', ['events' => Event::live()->upcoming()->latest()->get()->map->presentForLang(app()->getLocale())]);
    }

    public function show(Event $event)
    {
        return view('front.events.show', ['event' => EventPresenter::forPublic($event, app()->getLocale())]);
    }
}
