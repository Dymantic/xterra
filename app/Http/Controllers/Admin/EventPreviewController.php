<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use App\Occasions\EventPresenter;
use Illuminate\Http\Request;

class EventPreviewController extends Controller
{
    public function show(Event $event)
    {
        $lang = request('lang', 'en');
        app()->setLocale($lang);

        return view('front.events.show', ['event' => EventPresenter::forPublic($event, $lang)]);
    }
}
