<?php


namespace App\Occasions;


trait HasSchedule
{
    public function scheduleEntries()
    {
        return $this->hasMany(ScheduleEntry::class);
    }

    public function setSchedule(Schedule $schedule)
    {
        $this->clearSchedule();
        $schedule->entries->each(fn ($entry) => $this->scheduleEntries()->create($entry));
    }

    public function clearSchedule()
    {
        $this->scheduleEntries()->delete();
    }
}
