<?php

namespace App\Http\Controllers\Admin;

use App\HomePage;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmbeddableVideoRequest;
use Illuminate\Http\Request;

class HomePagePromoVideoController extends Controller
{
    public function store(EmbeddableVideoRequest $request)
    {
        HomePage::current()->setPromoVideo($request->video_id, $request->videoTitle());
    }

    public function destroy()
    {
        HomePage::current()->clearPromoVideo();
    }
}
