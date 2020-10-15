<?php


namespace App\Occasions;


use App\DatePresenter;

class EventPresenter
{
    public static function forAdmin(Event $event): array
    {
        $event->load('activities.scheduleEntries', 'fees', 'scheduleEntries', 'accommodations', 'travelRoutes',
            'activities.courses', 'galleries');

        return [
            'id'                => $event->id,
            'name'              => $event->name,
            'slug'              => $event->slug,
            'location'          => $event->location,
            'venue_name'        => $event->venue_name,
            'venue_address'     => $event->venue_address,
            'venue_maplink'     => $event->venue_maplink,
            'start'             => DatePresenter::standard($event->start),
            'end'               => DatePresenter::standard($event->end),
            'dates'             => DatePresenter::range($event->start, $event->end),
            'registration_link' => $event->registration_link,
            'overview'          => $event->overview->toArray(),
            'categories'        => $event->listCategories(),
            'activities'        => $event->activities()->orderBy('date')->get()->map->toArray(),
            'fees'              => $event->fees->map->toArray(),
            'schedule'          => Schedule::forEvent($event)->toArray(),
            'accommodation'     => $event->accommodations->map->toArray(),
            'travel_routes'     => $event->travelRoutes->map->toArray(),
            'travel_guide'      => $event->getTravelGuideUrl(),
            'courses'           => [],
            'galleries'         => $event->galleries->map->toArray()->values()->all(),
            'promo_video'       => optional($event->promoVideo)->getVideo(),
            'videos'            => $event->embeddableVideos->map->toArray()->values()->all(),
            'banner_image'      => $event->getBannerImage(),
            'card_image'        => $event->getCardImage(),
        ];
    }

    public static function forPublic(Event $event, $lang)
    {
        $event->load('activities.scheduleEntries', 'fees', 'scheduleEntries', 'accommodations', 'travelRoutes',
            'activities.courses', 'galleries');

        return [
            'name'              => $event->name[$lang] ?? '',
            'slug'              => $event->slug,
            'location'          => $event->location[$lang] ?? '' ,
            'venue_name'        => $event->venue_name[$lang] ?? '',
            'venue_address'     => $event->venue_address[$lang] ?? '',
            'venue_maplink'     => $event->venue_maplink,
            'start'             => DatePresenter::standard($event->start),
            'end'               => DatePresenter::standard($event->end),
            'dates'             => DatePresenter::range($event->start, $event->end),
            'registration_link' => $event->registration_link,
            'overview'          => $event->overview->in($lang),
            'categories'        => $event->listCategories(),
            'races'        => $event->activities()->where('is_race', true)->orderBy('date')->get()->map(fn ($activity) => ActivityPresenter::forPublic($activity, $lang)),
            'activities'        => $event->activities()->where('is_race', false)->orderBy('date')->get()->map(fn ($activity) => ActivityPresenter::forPublic($activity, $lang)),
            'fees'              => $event->fees->sortBy('position')->map->presentForLang($lang),
            'schedule'          => Schedule::forEvent($event)->presentForLang($lang, $event->start),
            'accommodation'     => $event->accommodations->map->presentForLang($lang),
            'travel_routes'     => $event->travelRoutes->map->presentForLang($lang),
            'travel_guide'      => $event->getTravelGuideUrl(),
            'courses'           => [],
            'galleries'         => $event->galleries->map->presentForLang($lang)->values()->all(),
            'promo_video'       => optional($event->promoVideo)->getVideo(),
            'videos'            => $event->embeddableVideos->map->toArray()->values()->all(),
            'banner_image'      => $event->getBannerImage(),
            'card_image'        => $event->getCardImage(),
        ];
    }

    public static function forHomePage(?Event $event, $lang)
    {
        if (!$event) {
            return null;
        }

        $event->load('activities.scheduleEntries', 'fees', 'scheduleEntries', 'accommodations', 'travelRoutes',
            'activities.courses', 'galleries');

        return [
            'name'         => $event->name[$lang] ?? '',
            'slug'         => $event->slug,
            'location'     => $event->location[$lang] ?? '',
            'dates'        => DatePresenter::range($event->start, $event->end),
            'banner_image' => $event->getBannerImage(),
            'categories'   => $event->listCategories(),
        ];
    }
}
