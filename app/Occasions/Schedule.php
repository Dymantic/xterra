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
            'location' => ['en' => $entry['location']['en'] ?? '', 'zh' => $entry['location']['zh'] ?? ''],
            'time_of_day' => ['en' => $entry['time_of_day']['en'] ?? '', 'zh' => $entry['time_of_day']['zh'] ?? ''],
            'position' => $entry['position'],
        ]);
    }

    public static function forEvent( $event): self
    {
        $schedule = new self([]);
        $days = $event->scheduleEntries->each(fn (ScheduleEntry $entry) => $schedule->addEntry($entry->day_of_event, [
            'item' => $entry->item,
            'time_of_day' => $entry->time_of_day,
            'location' => $entry->location ?? ['en' => '', 'zh' => ''],
            'position' => $entry->position,
        ]));

        return $schedule;

    }

    public function toArray(): array
    {
        return $this->entries->groupBy('day_of_event')->map(function($entries, $day) {
            return [
                'day' => $day,
                'entries' => $entries->map(fn ($entry) => [
                    'item' => $entry['item'],
                    'time_of_day' => $entry['time_of_day'],
                    'location' => $entry['location'],
                    'position' => $entry['position'],
                ])->values()->all(),
            ];
        })->values()->all();
    }
}
