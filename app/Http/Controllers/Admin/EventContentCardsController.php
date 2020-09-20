<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Media\ContentCard;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventContentCardsController extends Controller
{
    public function store()
    {
        $event = Event::findOrFail(request('event_id'));

        ContentCard::fromExistingContent($event);
    }
}
