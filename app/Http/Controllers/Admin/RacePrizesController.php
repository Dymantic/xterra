<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use App\Occasions\Event;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RacePrizesController extends Controller
{
    public function update(Activity $race)
    {
        request()->validate([
            'prizes' => ['required'],
            'lang'   => ['required', Rule::in(['en', 'zh'])],
        ]);

        $race->setPrizes(request('prizes'), request("lang"));
    }

    public function destroy(Activity $race)
    {
        $race->clearPrizes();
    }
}
