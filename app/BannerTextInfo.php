<?php


namespace App;


class BannerTextInfo
{
    public Translation $banner_heading;
    public Translation $banner_subheading;

    public function __construct($info)
    {
        $this->banner_heading = new Translation($info['heading'] ?? []);
        $this->banner_subheading = new Translation($info['subheading'] ?? []);
    }

    public function toArray(): array
    {
        return [
            'banner_heading' => $this->banner_heading,
            'banner_subheading' => $this->banner_subheading,
        ];
    }
}
