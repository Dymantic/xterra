<?php


namespace App;


use App\Campaigns\CampaignPresenter;
use App\Media\ContentCard;
use App\Occasions\Event;
use App\Occasions\EventPresenter;
use App\Shop\Promotion;

class HomePagePresenter
{
    public static function forPublic(HomePage $homePage, $lang)
    {
        $banner = $homePage->bannerImage();
        $event = $homePage->event ?? Event::live()->latest()->get();
        $promotion = $homePage->promotion;
        $promo_image = optional($promotion)->getFirstMedia(Promotion::IMAGE);
        $campaign = $homePage->campaign;

        return [
            'banner_lg' => $banner['full'],
            'banner_sm' => $banner['small'],
            'event' => EventPresenter::forHomePage($event, $lang),
            'campaign' => CampaignPresenter::forHomePage($campaign, $lang),
            'promotion' => [
                'title'       => $promotion->title->in($lang),
                'writeup'     => $promotion->writeup->in($lang),
                'button_text' => $promotion->button_text->in($lang),
                'image' => optional($promo_image)->getUrl('web'),
            ],
            'content_cards' => ContentCard::latest()->limit(6)->get()->map(function(ContentCard $card) use ($lang) {
                $image = $card->getFirstMedia(ContentCard::IMAGE);
                return [
                    'title' => $card->title->in($lang),
                    'category' => $card->category->in($lang),
                    'image' => optional($image)->getUrl('web'),
                ];
            }),
        ];
    }
}
