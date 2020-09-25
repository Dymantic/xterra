<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use App\Occasions\Event;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class RacePrizesController extends Controller
{
    public function update(Activity $race)
    {
        request()->validate([
            'prizes' => ['required', 'array'],
            'prizes.*' => ['array'],
            'prizes.*.category' => [new AtLeastOneTranslation()],
            'prizes.*.prize' => [new AtLeastOneTranslation()],
            'prizes.*.position' => ['required', 'integer'],
        ]);

        $race->setPrizes(request('prizes'));
    }

    public function destroy(Activity $race)
    {
        $race->clearPrizes();
    }
}
