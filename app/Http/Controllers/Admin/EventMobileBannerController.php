<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventMobileBannerController extends Controller
{
    public function store(Event $event)
    {
        request()->validate([
            'image' => ['image']
        ]);

        $event->setMobileBanner(request('image'));
    }

    public function destroy(Event $event)
    {
        $event->clearMobileBanner();
    }
}
