<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmbeddableVideoRequest;
use App\Occasions\Activity;
use Illuminate\Http\Request;

class RacePromoVideoController extends Controller
{
    public function store(EmbeddableVideoRequest $request, Activity $race)
    {
        $race->addYoutubeVideo($request->video_id, $request->videoTitle());
    }
}
