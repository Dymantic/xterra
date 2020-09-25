<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RaceRulesController extends Controller
{
    public function update(Activity $race)
    {
        request()->validate([
            'lang' => ['required', Rule::in(['en', 'zh'])],
        ]);

        $race->updateRules(request('rules'), request('lang'));
    }
}
