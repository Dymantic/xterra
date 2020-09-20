<?php


namespace App\Media;


use App\Translation;

class GalleryInfo
{
    public Translation $title;
    public Translation $description;

    public function __construct($info)
    {
        $this->title = new Translation([
            'en' => $info['title']['en'] ?? '',
            'zh' => $info['title']['zh'] ?? '',
        ]);

        $this->description = new Translation([
            'en' => $info['description']['en'] ?? '',
            'zh' => $info['description']['zh'] ?? '',
        ]);
    }

    public function toArray(): array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
        ];
    }
}
