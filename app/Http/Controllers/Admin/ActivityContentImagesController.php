<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use Illuminate\Http\Request;

class ActivityContentImagesController extends Controller
{
    public function store(Activity $race)
    {
        request()->validate([
            'image' => ['image'],
        ]);

        $image = $race->addContentImage(request('image'));

        return [
            'success' => 1,
            'file' => ['url' => $image->getUrl()],
        ];
    }
}
