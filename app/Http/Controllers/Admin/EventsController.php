<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    public function index()
    {
        return Event::all()->map->presentForAdmin();
    }


    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'name.en' => ['required_without:name.zh'],
            'name.zh' => ['required_without:name.en'],
        ]);
        Event::createWithName(request('name'));
    }

    public function delete(Event $event)
    {
        $event->safeDelete();
    }
}
