<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use Illuminate\Http\Request;

class RaceBannerImageController extends Controller
{
    public function store(Activity $race)
    {
        request()->validate([
            'image' => ['image']
        ]);

        $race->setBannerImage(request('image'));
    }
}
