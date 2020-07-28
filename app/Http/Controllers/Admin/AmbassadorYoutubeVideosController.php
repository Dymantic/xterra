<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmbeddableVideoRequest;
use App\People\Ambassador;
use Illuminate\Http\Request;

class AmbassadorYoutubeVideosController extends Controller
{
    public function store(Ambassador $ambassador, EmbeddableVideoRequest $request)
    {
        $request->validate(['video_id' => ['required']]);

        $ambassador->addYoutubeVideo($request->video_id, $request->videoTitle());
    }
}
