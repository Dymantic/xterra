<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use App\Translation;
use Illuminate\Http\Request;

class EventOverviewController extends Controller
{
    public function update(Event $event)
    {
        $event->setOverview(new Translation(request('overview')));
    }
}
