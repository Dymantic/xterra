<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Media\EmbeddableVideo;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class EmbeddableVideosController extends Controller
{
    public function update(EmbeddableVideo $video)
    {
        request()->validate([
            'title' => [new AtLeastOneTranslation()],
        ]);

        $video->update(request()->only('title'));
    }

    public function delete(EmbeddableVideo $video)
    {
        $video->delete();
    }
}
