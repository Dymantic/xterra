<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class EventFeesController extends Controller
{
    public function update(Event $event)
    {
        request()->validate([
            'fees' => ['required', 'array'],
            'fees.*' => ['array'],
            'fees.*.fee' => ['required'],
            'fees.*.category' => ['required', new AtLeastOneTranslation()],
            'fees.*.position' => ['required', 'integer']
        ]);

        $event->setFees(request('fees'));
    }

    public function destroy(Event $event)
    {
        $event->clearFees();
    }
}
