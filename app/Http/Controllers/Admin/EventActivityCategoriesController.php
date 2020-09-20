<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Http\Request;

class EventActivityCategoriesController extends Controller
{
    public function index()
    {
        return collect(Activity::ACTIVITY_TYPES)->flatMap(fn ($type) => [$type => $type]);
    }
}
