<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmbeddableVideoRequest;
use App\Occasions\Event;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class EventYoutubeVideosController extends Controller
{
    public function store(Event $event, EmbeddableVideoRequest $request)
    {
        request()->validate([
            'title' => [new AtLeastOneTranslation()],
            'video_id' => ['required']
        ]);

        $event->addYoutubeVideo($request->video_id, $request->videoTitle());
    }
}
