<?php

namespace App\Http\Controllers;

use App\People\Ambassador;
use App\People\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PeopleController extends Controller
{
    public function index()
    {
        $ambassadors = Ambassador::latest()->get();
        $coaches = Coach::latest()->get();

        return view('front.people.index', [
            'people' => $ambassadors
                ->concat($coaches)
                ->sortByDesc('created_at')
                ->map->presentForPersonCard(app()->getLocale())
                ->values()->all(),
        ]);
    }
}
