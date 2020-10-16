<?php


namespace App;


use App\Campaigns\CampaignPresenter;
use App\Media\ContentCard;
use App\Occasions\Event;
use App\Occasions\EventPresenter;
use App\Shop\Promotion;
use Dymantic\InstagramFeed\Profile;

class HomePagePresenter
{
    public static function forPublic(HomePage $homePage, $lang)
    {
        $banner = $homePage->bannerImage();
        $event = $homePage->event ?? Event::live()->latest()->first();
        $promotion = $homePage->promotion;
        $promo_image = optional($promotion)->getFirstMedia(Promotion::IMAGE);
        $campaign = $homePage->campaign;
        $ig_profile = Profile::where('username', 'xterra')->first();

        return [
            'banner_lg'     => $banner['full'],
            'banner_sm'     => $banner['small'],
            'banner_heading' => $homePage->banner_heading->in($lang),
            'banner_subheading' => $homePage->banner_subheading->in($lang),
            'event'         => EventPresenter::forHomePage($event, $lang),
            'campaign'      => CampaignPresenter::forHomePage($campaign, $lang),
            'promotion'     => [
                'title'       => $promotion->title->in($lang),
                'writeup'     => $promotion->writeup->in($lang),
                'button_text' => $promotion->button_text->in($lang),
                'link'        => $promotion->link,
                'image'       => optional($promo_image)->getUrl('web'),
            ],
            'content_cards' => ContentCard::latest()->limit(6)->get()->map(function (ContentCard $card) use ($lang) {
                $image = $card->getFirstMedia(ContentCard::IMAGE);

                return [
                    'title'    => $card->title->in($lang),
                    'category' => $card->category->in($lang),
                    'link'     => $card->link,
                    'image'    => optional($image)->getUrl('web'),
                ];
            }),
            'blog'          => [
                'posts' => app('live-posts')->for(app()->getLocale())->getPage(1, 6)['posts'],
            ],
            'instagram'     => [
                'posts' => optional($ig_profile)->feed(),
            ],
            'banner_video' => $homePage->bannerVideoUrl(),
        ];
    }

    public static function forAdmin(HomePage $homePage): array
    {
        $homePage->load('campaign', 'event', 'promotion', 'bannerVideo');

        return [
            'banner_image' => $homePage->bannerImage(),
            'banner_text'  => [
                'heading'    => $homePage->banner_heading->toArray(),
                'subheading' => $homePage->banner_subheading->toArray(),
            ],
            'banner_video' => $homePage->bannerVideoUrl(),
            'promo_video' => optional($homePage->promoVideo)->getVideo(),
            'event'        => $homePage->event ? EventPresenter::forAdmin($homePage->event) : null,
            'campaign'     => $homePage->campaign ? CampaignPresenter::forAdmin($homePage->campaign) : null,
            'promotion'    => optional($homePage->promotion)->toArray(),
        ];
    }
}
