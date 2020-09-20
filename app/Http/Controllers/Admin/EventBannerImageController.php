<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventBannerImageController extends Controller
{
    public function store(Event $event)
    {
        request()->validate([
            'image' => ['image']
        ]);

        $event->setBannerImage(request('image'));
    }

    public function destroy(Event $event)
    {
        $event->clearBannerImage();
    }
}
