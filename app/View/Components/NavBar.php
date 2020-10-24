<?php

namespace App\View\Components;

use App\Occasions\Event;
use App\Occasions\EventPresenter;
use Illuminate\View\Component;

class NavBar extends Component
{
    public $upcomingEvents;

    public function __construct()
    {
        $this->upcomingEvents = Event::with('activities')
                                     ->live()
                                     ->upcoming()
                                     ->limit(3)
                                     ->get()
                                     ->map(fn($event) => EventPresenter::forPublic($event, app()->getLocale()));
    }


    public function render()
    {
        return view('components.nav-bar');
    }
}
