<?php


namespace App\Occasions;


use Illuminate\Support\Carbon;

class ActivityInfo
{

    public array $name;
    public array $distance;
    public array $venue_name;
    public array $venue_address;
    public string $category;
    public string $map_link;
    public string $registration_link;
    public ?Carbon $date;
    public bool $is_race;

    public function __construct(array $data)
    {
        $this->name = [
            'en' => $data['name']['en'] ?? '',
            'zh' => $data['name']['zh'] ?? '',
        ];

        $this->distance = [
            'en' => $data['distance']['en'] ?? '',
            'zh' => $data['distance']['zh'] ?? '',
        ];



        $this->venue_name = [
            'en' => $data['venue_name']['en'] ?? '',
            'zh' => $data['venue_name']['zh'] ?? '',
        ];

        $this->venue_address = [
            'en' => $data['venue_address']['en'] ?? '',
            'zh' => $data['venue_address']['zh'] ?? '',
        ];

        $this->date = $data['date'] ?? false ? Carbon::parse($data['date']) : null;

        $this->registration_link = $data['registration_link'] ?? '';
        $this->map_link = $data['map_link'] ?? '';

        $this->category = $data['category'] ?? Activity::NO_CATEGORY;
        $this->is_race = $data['is_race'] ?? false;
    }

    public static function forRace($data): self
    {
        return new self(array_merge($data, ['is_race' => true]));
    }

    public static function forActivity($data): self
    {
        return new self(array_merge($data, ['is_race' => false]));
    }

    public function toArray(): array
    {
        return [
            'name'              => $this->name,
            'distance'          => $this->distance,
            'date'              => $this->date,
            'venue_name'        => $this->venue_name,
            'venue_address'     => $this->venue_address,
            'map_link'          => $this->map_link,
            'registration_link' => $this->registration_link,
            'category'          => $this->category,
            'is_race'           => $this->is_race,
        ];
    }
}
