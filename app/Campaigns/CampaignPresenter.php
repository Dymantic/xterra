<?php


namespace App\Campaigns;


use App\Occasions\EventPresenter;

class CampaignPresenter
{
    public static function forAdmin(Campaign $campaign): array
    {
        $campaign->load('event', 'promotion', 'articles');
        $titleImage = $campaign->titleImage();

        return [
            'id'          => $campaign->id,
            'title'       => $campaign->title->toArray(),
            'intro'       => $campaign->intro->toArray(),
            'description' => $campaign->description->toArray(),
            'title_image' => self::presentImage($titleImage),
            'narrative_raw' => $campaign->narrative->toArray(),
            'narrative_html' => [
                'en' => $campaign->narrativeHtml('en'),
                'zh' => $campaign->narrativeHtml('zh'),
            ],
            'event' => $campaign->event ? EventPresenter::forAdmin($campaign->event) : null,
            'promotion' => $campaign->promotion ? $campaign->promotion->toArray() : null,
            'articles' => $campaign->articles->map->toArray()->values()->all(),
        ];
    }

    public static function forHomePage(?Campaign $campaign, $lang)
    {
        if(!$campaign) {
            return null;
        }

        $campaign->load('event', 'promotion', 'articles');
        $titleImage = $campaign->titleImage();

        return [
            'title'       => $campaign->title->in($lang),
            'intro'       => $campaign->intro->in($lang),
            'title_image' => self::presentImage($titleImage),
        ];
    }

    public static function presentImage($image)
    {
        return [
            'thumb'    => $image ? $image->getUrl('thumb') : Campaign::DEFAULT_IMAGE,
            'web'      => $image ? $image->getUrl('web') : Campaign::DEFAULT_IMAGE,
            'original' => $image ? $image->getUrl() : Campaign::DEFAULT_IMAGE,
        ];
    }
}
