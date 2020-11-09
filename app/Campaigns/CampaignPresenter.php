<?php


namespace App\Campaigns;


use App\Occasions\EventPresenter;
use Illuminate\Support\Str;

class CampaignPresenter
{
    public static function forAdmin(Campaign $campaign): array
    {
        $campaign->load('event', 'promotion', 'articles');
        $titleImage = $campaign->titleImage();
        $banner_image = $campaign->getFirstMedia(Campaign::BANNER_IMAGE);

        return [
            'id'             => $campaign->id,
            'title'          => $campaign->title->toArray(),
            'is_public'      => $campaign->is_public,
            'intro'          => $campaign->intro->toArray(),
            'description'    => $campaign->description->toArray(),
            'title_image'    => self::presentImage($titleImage),
            'narrative_raw'  => $campaign->narrative->toArray(),
            'narrative_html' => [
                'en' => $campaign->narrativeHtml('en'),
                'zh' => $campaign->narrativeHtml('zh'),
            ],
            'event'          => $campaign->event ? EventPresenter::forAdmin($campaign->event) : null,
            'promotion'      => $campaign->promotion ? $campaign->promotion->toArray() : null,
            'articles'       => $campaign->articles->map->toArray()->values()->all(),
            'banner_image'   => [
                'full'  => optional($banner_image)->getUrl('full') ?? Campaign::DEFAULT_IMAGE,
                'small' => optional($banner_image)->getUrl('small') ?? Campaign::DEFAULT_IMAGE,
            ],
            'promo_video'    => optional($campaign->promoVideo)->getVideo(),
            'banner_video'   => $campaign->bannerVideoUrl(),
        ];
    }

    public static function forHomePage(?Campaign $campaign, $lang)
    {
        if (!$campaign) {
            return null;
        }

        $campaign->load('event', 'promotion', 'articles');
        $titleImage = $campaign->titleImage();

        return [
            'title'     => $campaign->title->in($lang),
            'full_slug' => sprintf('/initiatives/%s/%s', $campaign->slug, Str::slug($campaign->title->in('en'))),
            'intro'     => $campaign->intro->in($lang),
            'image'     => self::presentImage($titleImage)['web'],
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

    public static function forPublic(Campaign $campaign, $lang)
    {
        $campaign->load('event', 'promotion', 'articles');
        $titleImage = $campaign->titleImage();
        $banner_image = $campaign->getFirstMedia(Campaign::BANNER_IMAGE);

        return [
            'slug'           => $campaign->slug,
            'full_slug'      => sprintf('/initiatives/%s/%s', $campaign->slug, Str::slug($campaign->title->in('en'))),
            'canonical_slug' => localUrl("/initiatives/{$campaign->slug}"),
            'title'          => $campaign->title->in($lang),
            'intro'          => $campaign->intro->in($lang),
            'description'    => $campaign->description->in($lang),
            'title_image'    => self::presentImage($titleImage),
            'narrative_html' => $campaign->narrativeHtml($lang),
            'event'          => $campaign->event ? EventPresenter::forHomePage($campaign->event, $lang) : null,
            'promotion'      => $campaign->promotion ? $campaign->promotion->presentForLang($lang) : null,
            'articles'       => app('live-posts')->for($lang)->getPosts($campaign->articles)->take(3),
            'banner_image'   => [
                'full'  => optional($banner_image)->getUrl('full') ?? Campaign::DEFAULT_IMAGE,
                'small' => optional($banner_image)->getUrl('small') ?? Campaign::DEFAULT_IMAGE,
            ],
            'promo_video_id' => optional($campaign->promoVideo)->getVideoId(),
            'banner_video'   => $campaign->bannerVideoUrl(),
        ];
    }
}
