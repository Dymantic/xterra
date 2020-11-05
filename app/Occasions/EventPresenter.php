<?php


namespace App\Occasions;


use App\DatePresenter;
use Illuminate\Support\Str;

class EventPresenter
{
    public static function forAdmin(Event $event): array
    {
        $event->load('activities.scheduleEntries', 'fees', 'scheduleEntries', 'accommodations', 'travelRoutes',
            'activities.courses', 'galleries', 'sponsors');

        return [
            'id'                => $event->id,
            'name'              => $event->name,
            'slug'              => $event->slug,
            'is_public'         => $event->is_public,
            'intro'             => $event->intro ?? ['en' => '', 'zh' => ''],
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
            'sponsors'          => $event->sponsors()->orderBy('position')->get()->map->toArray()->values()->all(),
            'courses'           => [],
            'galleries'         => $event->galleries->map->toArray()->values()->all(),
            'promo_video'       => optional($event->promoVideo)->getVideo(),
            'videos'            => $event->embeddableVideos->map->toArray()->values()->all(),
            'banner_image'      => $event->getBannerImage(),
            'card_image'        => $event->getCardImage(),
            'mobile_banner'     => $event->getMobileBanner(),
        ];
    }

    public static function forPublic(Event $event, $lang)
    {
        $event->load('activities.scheduleEntries', 'fees', 'scheduleEntries', 'accommodations', 'travelRoutes',
            'activities.courses', 'galleries', 'sponsors');
        $slugged_name = Str::slug($event->name[$lang]);
        $races = $event
            ->activities()
            ->where('is_race', true)
            ->orderBy('date')->get()->map(
                fn($activity) => ActivityPresenter::forPublic($activity, $lang)
            );
        $activities = $event
            ->activities()
            ->where('is_race', false)
            ->orderBy('date')->get()->map(
                fn($activity) => ActivityPresenter::forPublic($activity, $lang)
            );
        $fees = $event->fees->sortBy('position')->map->presentForLang($lang);
        $schedule = Schedule::forEvent($event)->presentForLang($lang, $event->start);
        $accomodation = $event->accommodations->map->presentForLang($lang);
        $travel_routes = $event->travelRoutes->map->presentForLang($lang);
        $sponsors = $event->sponsors()->orderBy('position')->get()->map->presentForLang($lang);
        $galleries = $event->galleries->map->presentForLang($lang)->values()->all();
        $videos = $event->embeddableVideos->map->presentForLang($lang)->values()->all();
        $banner_image = $event->getBannerImage(Event::DEFAULT_BANNER);

        return [
            'name'              => $event->name[$lang] ?? '',
            'slug'              => $event->slug,
            'full_slug'         => "/events/{$event->slug}/{$slugged_name}",
            'intro'             => $event->intro[$lang] ?? '',
            'location'          => $event->location[$lang] ?? '',
            'venue_name'        => $event->venue_name[$lang] ?? '',
            'venue_address'     => $event->venue_address[$lang] ?? '',
            'venue_maplink'     => $event->venue_maplink,
            'start'             => DatePresenter::standard($event->start),
            'end'               => DatePresenter::standard($event->end),
            'dates'             => DatePresenter::range($event->start, $event->end),
            'registration_link' => $event->registration_link,
            'overview'          => $event->overview->in($lang),
            'categories'        => $event->listCategories(),
            'has_activities'    => !!($races->count() || $activities->count()),
            'race_menu_name'    => $races->count() > 1 ? trans('navbar.event_nav.races') : trans('navbar.event_nav.activities'),
            'races'             => $races,
            'activities'        => $activities,
            'fees'              => $fees,
            'has_fees'          => $fees->count() > 0,
            'schedule'          => $schedule,
            'has_schedule'      => count($schedule) > 0,
            'accommodation'     => $accomodation,
            'has_accommodation' => $accomodation->count() > 0,
            'travel_routes'     => $travel_routes,
            'has_travel'        => $travel_routes->count() > 0,
            'travel_guide'      => $event->getTravelGuideUrl(),
            'sponsors'          => $sponsors,
            'has_sponsors'      => $sponsors->count() > 0,
            'galleries'         => $galleries,
            'has_galleries'     => count($galleries) > 0,
            'promo_video_id'    => optional($event->promoVideo)->getVideoId(),
            'videos'            => $videos,
            'has_videos'        => count($videos) > 0,
            'banner_image'      => $banner_image,
            'mobile_banner'     => $event->getMobileBanner($banner_image['banner']),
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
        $slugged_name = Str::slug($event->name[$lang]);

        return [
            'name'         => $event->name[$lang] ?? '',
            'slug'         => $event->slug,
            'full_slug'    => "/events/{$event->slug}/{$slugged_name}",
            'location'     => $event->location[$lang] ?? '',
            'dates'        => DatePresenter::range($event->start, $event->end),
            'banner_image' => $event->getBannerImage(Event::DEFAULT_BANNER),
            'categories'   => $event->listCategories(),
        ];
    }
}
