<?php


namespace App\Occasions;


class CourseInfo
{
    public array $name;
    public array $distance;
    public array $description;

    public function __construct($data)
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
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'distance' => $this->distance,
            'description' => $this->description,
        ];
    }
}
