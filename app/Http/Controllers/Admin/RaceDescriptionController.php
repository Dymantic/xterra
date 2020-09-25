<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use Illuminate\Http\Request;

class RaceDescriptionController extends Controller
{
    public function update(Activity $race)
    {
        $race->updateDescription(request('description'), request('lang'));
    }
}
