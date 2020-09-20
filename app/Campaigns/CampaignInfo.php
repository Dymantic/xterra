<?php


namespace App\Campaigns;

use App\Translation;

class CampaignInfo
{
    public Translation $title;
    public Translation $description;
    public Translation $intro;

    public function __construct(array $info)
    {
        $this->title = new Translation($info['title'] ?? []);
        $this->description = new Translation($info['description'] ?? []);
        $this->intro = new Translation($info['intro'] ?? []);
    }

    public function toArray(): array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'intro'       => $this->intro,
        ];
    }
}
