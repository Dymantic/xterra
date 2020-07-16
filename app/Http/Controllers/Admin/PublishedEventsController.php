<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use Illuminate\Http\Request;

class PublishedEventsController extends Controller
{
    public function store()
    {
        Event::findOrFail(request('event_id'))->publish();
    }
}
