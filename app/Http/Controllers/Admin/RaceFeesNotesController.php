<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use App\Rules\TranslationArray;
use Illuminate\Http\Request;

class RaceFeesNotesController extends Controller
{
    public function update(Activity $race)
    {
        request()->validate(['notes' => [new TranslationArray()]]);

        $race->setFeesNotes(request('notes'));
    }
}
