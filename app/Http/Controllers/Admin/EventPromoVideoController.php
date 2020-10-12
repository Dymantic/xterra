<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmbeddableVideoRequest;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventPromoVideoController extends Controller
{
    public function store(EmbeddableVideoRequest $request, Event $event)
    {
        $event->setPromoVideo($request->video_id, $request->videoTitle());
    }

    public function destroy(Event $event)
    {
        $event->clearPromoVideo();
    }
}
