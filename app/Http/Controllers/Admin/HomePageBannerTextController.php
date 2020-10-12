<?php

namespace App\Http\Controllers\Admin;

use App\HomePage;
use App\Http\Controllers\Controller;
use App\Http\Requests\HomePageBannerTextRequest;
use Illuminate\Http\Request;

class HomePageBannerTextController extends Controller
{
    public function update(HomePageBannerTextRequest $request)
    {
        HomePage::current()->setBannerText($request->bannerTextInfo());
    }
}
