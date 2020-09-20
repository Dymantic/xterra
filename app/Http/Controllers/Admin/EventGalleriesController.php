<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Media\Gallery;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventGalleriesController extends Controller
{
    public function store(Event $event)
    {
        request()->validate([
            'gallery_id' => ['required', 'exists:galleries,id'],
        ]);

        $event->addGallery(request('gallery_id'));
    }

    public function destroy(Event $event, Gallery $gallery)
    {
        $event->removeGallery($gallery->id);
    }
}
