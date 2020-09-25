<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class RaceFeesController extends Controller
{
    public function update(Activity $race)
    {
        request()->validate([
            'fees' => ['required', 'array'],
            'fees.*' => ['array'],
            'fees.*.fee' => ['required'],
            'fees.*.category' => ['required', new AtLeastOneTranslation()],
            'fees.*.position' => ['required', 'integer']
        ]);

        $race->setFees(request('fees'));
    }

    public function destroy(Activity $race)
    {
        $race->clearFees();
    }
}
