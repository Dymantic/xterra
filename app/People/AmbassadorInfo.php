<?php


namespace App\People;


use App\Translation;

class AmbassadorInfo
{
    public Translation $name;
    public Translation $about;
    public Translation $achievements;
    public Translation $collaboration;
    public Translation $philosophy;
    public array $social_links;

    public function __construct($info)
    {
        $this->name = new Translation($info['name'] ?? []);
        $this->about = new Translation($info['about'] ?? []);
        $this->achievements = new Translation($info['achievements'] ?? []);
        $this->collaboration = new Translation($info['collaboration'] ?? []);
        $this->philosophy = new Translation($info['philosophy'] ?? []);
        $this->social_links = $info['social_links'] ?? [];
    }

    public function toArray(): array
    {
        return [
            'name'          => $this->name,
            'about'         => $this->about,
            'achievements'  => $this->achievements,
            'collaboration' => $this->collaboration,
            'philosophy'    => $this->philosophy,
        ];
    }
}
