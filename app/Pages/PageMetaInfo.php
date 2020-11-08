<?php


namespace App\Pages;


use App\Translation;

class PageMetaInfo
{
    public Translation $title;
    public Translation $description;
    public Translation $blurb;
    public Translation $menu_name;

    public function __construct($info)
    {
        $this->title = new Translation($info['title'] ?? []);
        $this->description = new Translation($info['description'] ?? []);
        $this->blurb = new Translation($info['blurb'] ?? []);
        $this->menu_name = new Translation($info['menu_name'] ?? []);
    }

    public function toArray(): array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'blurb'       => $this->blurb,
            'menu_name'   => $this->menu_name,
        ];
    }
}
