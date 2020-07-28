<?php


namespace App\People;


trait IsSociable
{
    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'sociable');
    }

    public function setSocialLinks(array $links)
    {
        $this->socialLinks()->delete();

        collect($links)->each(fn($link) => $this->addSocialLink($link['platform'], $link['link']));
    }

    public function addSocialLink(string $platform, string $link)
    {
        $this->socialLinks()->create(['platform' => $platform, 'link' => $link]);
    }
}
