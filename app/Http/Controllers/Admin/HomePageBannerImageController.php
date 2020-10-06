<?php

namespace App\Http\Controllers\Admin;

use App\HomePage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomePageBannerImageController extends Controller
{
    public function store()
    {
        request()->validate(['image' => ['image']]);

        HomePage::current()->setBannerImage(request('image'));
    }

    public function destroy()
    {
        HomePage::current()->clearBannerImage();
    }
}
