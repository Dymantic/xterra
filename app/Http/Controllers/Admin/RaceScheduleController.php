<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use App\Occasions\Schedule;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Http\Request;

class RaceScheduleController extends Controller
{
    public function update(Activity $race)
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
        $race->setSchedule($schedule);
    }

    public function destroy(Activity $race)
    {
        $race->clearSchedule();
    }
}
