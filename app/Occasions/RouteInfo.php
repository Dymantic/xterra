<?php


namespace App\Occasions;


class RouteInfo
{

    public array $name;
    public array $description;

    public function __construct(array $data)
    {
        $this->name = [
            'en' => $data['name']['en'] ?? '',
            'zh' => $data['name']['zh'] ?? '',
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
            'description' => $this->description,
        ];
    }
}
