<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\People\Coach;
use Illuminate\Http\Request;

class PublishedCoachesController extends Controller
{
    public function store()
    {
        Coach::findOrFail(request('coach_id'))->publish();
    }

    public function destroy(Coach $coach)
    {
        $coach->retract();
    }
}
