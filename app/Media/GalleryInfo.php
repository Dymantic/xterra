<?php


namespace App\Media;


class GalleryInfo
{
    public array $title;
    public array $description;

    public function __construct($info)
    {
        $this->title = [
            'en' => $info['title']['en'] ?? '',
            'zh' => $info['title']['zh'] ?? '',
        ];

        $this->description = [
            'en' => $info['description']['en'] ?? '',
            'zh' => $info['description']['zh'] ?? '',
        ];
    }

    public function toArray(): array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
        ];
    }
}
