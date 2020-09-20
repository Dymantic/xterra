<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Event;
use App\Occasions\Schedule;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class EventScheduleController extends Controller
{
    public function update(Event $event)
    {

        request()->validate([
            'schedule' => ['required', 'array'],
            'schedule.*.day' => ['required', 'integer'],
            'schedule.*.entries' => ['required', 'array'],
            'schedule.*.entries.*.time_of_day' => [new AtLeastOneTranslation()],
            'schedule.*.entries.*.item' => [new AtLeastOneTranslation()],
            'schedule.*.entries.*.position' => ['required', 'integer'],
        ]);

        $schedule = new Schedule(request('schedule'));

        $event->setSchedule($schedule);
    }

    public function destroy(Event $event)
    {
        $event->clearSchedule();
    }
}
