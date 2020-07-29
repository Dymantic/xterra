<?php


namespace App\Shop;


use App\Translation;

class PromotionInfo
{
    public Translation $title;
    public Translation $writeup;
    public Translation $button_text;
    public string $link;

    public function __construct($info)
    {
        $this->title = new Translation($info['title'] ?? []);
        $this->writeup = new Translation($info['writeup'] ?? []);
        $this->button_text = new Translation($info['button_text'] ?? []);
        $this->link = $info['link'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'title'       => $this->title,
            'writeup'     => $this->writeup,
            'button_text' => $this->button_text,
            'link'        => $this->link,
        ];
    }
}
