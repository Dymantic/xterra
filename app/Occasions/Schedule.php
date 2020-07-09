<?php


namespace App\Occasions;


use Illuminate\Support\Collection;

class Schedule
{
    public Collection $entries;

    public function __construct(array $days)
    {
        $this->entries = collect([]);

        collect($days)->each(fn($day) => $this->addDayEntries($day));
    }

    private function addDayEntries($day)
    {
        collect($day['entries'])
            ->each(fn($entry) => $this->addEntry($day['day'], $entry));
    }

    private function addEntry(int $day, array $entry)
    {
        $this->entries->push([
            'day_of_event' => $day,
            'item' => ['en' => $entry['item']['en'] ?? '', 'zh' => $entry['item']['zh'] ?? ''],
            'time_of_day' => $entry['time_of_day'],
            'position' => $entry['position'],
        ]);
    }
}
