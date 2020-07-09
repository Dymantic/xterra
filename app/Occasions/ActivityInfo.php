<?php


namespace App\Occasions;


class ActivityInfo
{

    public array $name;
    public array $distance;
    public array $description;
    public string $category;
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

        $this->description = [
            'en' => $data['description']['en'] ?? '',
            'zh' => $data['description']['zh'] ?? '',
        ];

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
            'name' => $this->name,
            'distance' => $this->distance,
            'description' => $this->description,
            'category' => $this->category,
            'is_race' => $this->is_race,
        ];
    }
}
