<?php


namespace App\Occasions;


use Illuminate\Support\Carbon;

class GeneralEventInfo
{

    public array $name;
    public array $intro;
    public array $location;
    public array $venue_name;
    public array $venue_address;
    public ?string $venue_maplink;
    public ?Carbon $start;
    public ?Carbon $end;
    public ?string $registration_link;

    public function __construct($info)
    {
        $this->name = ['en' => $info['name']['en'] ?? '', 'zh' => $info['name']['zh'] ?? ''];
        $this->intro = ['en' => $info['intro']['en'] ?? '', 'zh' => $info['intro']['zh'] ?? ''];
        $this->location = ['en' => $info['location']['en'] ?? '', 'zh' => $info['location']['zh'] ?? ''];
        $this->venue_name = ['en' => $info['venue_name']['en'] ?? '', 'zh' => $info['venue_name']['zh'] ?? ''];
        $this->venue_address = ['en' => $info['venue_address']['en'] ?? '', 'zh' => $info['venue_address']['zh'] ?? ''];
        $this->venue_maplink = $info['venue_maplink'] ?? null;
        $this->start = $info['start'] ?? null ? Carbon::parse($info['start'])->startOfDay() : null;
        $this->end = $info['end'] ?? null ? Carbon::parse($info['end'])->endOfDay() : null;
        $this->registration_link = $info['registration_link'] ?? null;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'intro' => $this->intro,
            'location' => $this->location,
            'venue_name' => $this->venue_name,
            'venue_address' => $this->venue_address,
            'venue_maplink' => $this->venue_maplink,
            'start' => $this->start,
            'end' => $this->end,
            'registration_link' => $this->registration_link,
        ];
    }

}
