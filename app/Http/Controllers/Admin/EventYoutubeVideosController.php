<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class EventYoutubeVideosController extends Controller
{
    public function store(Event $event)
    {
        request()->validate([
            'title' => [new AtLeastOneTranslation()],
            'video_id' => ['required']
        ]);

        $event->attachYoutubeVideo(request('video_id'), request('title'));
    }
}
