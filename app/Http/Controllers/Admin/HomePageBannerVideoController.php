<?php

namespace App\Http\Controllers\Admin;

use App\HomePage;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerVideoUploadRequest;
use Illuminate\Http\Request;

class HomePageBannerVideoController extends Controller
{
    public function store(BannerVideoUploadRequest $request)
    {
        HomePage::current()->setBannerVideo($request->video);
    }

    public function destroy()
    {
        HomePage::current()->clearBannerVideo();
    }
}
