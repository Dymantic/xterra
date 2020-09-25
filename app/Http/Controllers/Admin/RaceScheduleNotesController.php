<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use App\Rules\TranslationArray;
use Illuminate\Http\Request;

class RaceScheduleNotesController extends Controller
{
    public function update(Activity $race)
    {
        request()->validate(['notes' => [new TranslationArray()]]);

        $race->setScheduleNotes(request('notes'));
    }
}
