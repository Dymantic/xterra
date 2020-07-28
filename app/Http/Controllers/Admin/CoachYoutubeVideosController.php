<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmbeddableVideoRequest;
use App\People\Coach;
use Illuminate\Http\Request;

class CoachYoutubeVideosController extends Controller
{
    public function store(Coach $coach, EmbeddableVideoRequest $request)
    {
        $request->validate([
            'video_id' => ['required'],
        ]);

        $coach->addYoutubeVideo($request->video_id, $request->videoTitle());
    }
}
