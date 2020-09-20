<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmbeddableVideoRequest;
use App\Media\EmbeddableVideo;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class EmbeddableVideosController extends Controller
{
    public function update(EmbeddableVideo $video, EmbeddableVideoRequest $request)
    {
        $video->updateInfo($request->video_id, $request->videoTitle());
    }

    public function delete(EmbeddableVideo $video)
    {
        $video->delete();
    }
}
