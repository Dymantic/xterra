<?php


namespace App\Media;


use App\Translation;

class ContentCardInfo
{
    public Translation $title;
    public Translation $category;
    public string $link;
    public string $image_path;

    public function __construct($info)
    {
        $this->title = new Translation($info['title'] ?? []);
        $this->category = new Translation($info['category'] ?? []);
        $this->link = $info['link'] ?? '';
        $this->image_path = $info['image_path'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'title'    => $this->title,
            'category' => $this->category,
            'link'     => $this->link,
        ];
    }
}
