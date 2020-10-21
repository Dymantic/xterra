<?php


namespace App\Occasions;


use App\Translation;

class SponsorInfo
{

    public Translation $name;
    public Translation $description;
    public string $link;

    public function __construct($info)
    {
        $this->name = new Translation($info['name'] ?? []);
        $this->description = new Translation($info['description'] ?? []);
        $this->link = $info['link'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'link'        => $this->link,
        ];
    }


}
