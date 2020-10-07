<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\TravelRoute;
use Illuminate\Http\Request;

class TravelRouteImageController extends Controller
{
    public function store(TravelRoute $route)
    {
        request()->validate([
            'image' => ['image'],
        ]);

        $route->setImage(request('image'));
    }
}
