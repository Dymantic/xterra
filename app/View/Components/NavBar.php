<?php

namespace App\View\Components;

use App\Occasions\Event;
use App\Occasions\EventPresenter;
use App\Pages\Page;
use App\Pages\PagePresenter;
use Illuminate\View\Component;

class NavBar extends Component
{
    public $upcomingEvents;
    public $discoverPages;

    public function __construct()
    {
        $this->upcomingEvents = Event::with('activities')
                                     ->live()
                                     ->upcoming()
                                     ->orderBy('start')
                                     ->limit(3)
                                     ->get()
                                     ->map(fn($event) => EventPresenter::forPublic($event, app()->getLocale()));

        $this->discoverPages = Page::live()
                                   ->get()
                                   ->map(fn(Page $page) => PagePresenter::forPublic($page, app()->getLocale()));
    }


    public function render()
    {
        return view('components.nav-bar');
    }
}
