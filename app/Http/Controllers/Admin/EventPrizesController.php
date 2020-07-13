<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class EventPrizesController extends Controller
{
    public function update(Event $event)
    {
        request()->validate([
            'prizes' => ['required', 'array'],
            'prizes.*' => ['array'],
            'prizes.*.category' => [new AtLeastOneTranslation()],
            'prizes.*.prize' => [new AtLeastOneTranslation()],
            'prizes.*.position' => ['required', 'integer'],
        ]);

        $event->setPrizes(request('prizes'));
    }

    public function destroy(Event $event)
    {
        $event->clearPrizes();
    }
}
