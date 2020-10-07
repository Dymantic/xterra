<?php


namespace App\Occasions;


use App\DatePresenter;

class EventPresenter
{
    public static function forAdmin(Event $event): array
    {
        $event->load('activities.scheduleEntries', 'fees', 'scheduleEntries', 'accommodations', 'travelRoutes', 'activities.courses', 'galleries');
        return [
            'id' => $event->id,
            'name' => $event->name,
            'slug' => $event->slug,
            'location' => $event->location,
            'venue_name' => $event->venue_name,
            'venue_address' => $event->venue_address,
            'venue_maplink' => $event->venue_maplink,
            'start' => DatePresenter::standard($event->start),
            'end' => DatePresenter::standard($event->end),
            'dates' => DatePresenter::range($event->start, $event->end),
            'registration_link' => $event->registration_link,
            'overview' => $event->overview->toArray(),
            'categories' => $event->listCategories(),
            'activities' => $event->activities->map->toArray(),
            'fees' => $event->fees->map->toArray(),
            'schedule' => Schedule::forEvent($event)->toArray(),
            'accommodation' => $event->accommodations->map->toArray(),
            'travel_routes' => $event->travelRoutes->map->toArray(),
            'travel_guide' => $event->getTravelGuideUrl(),
            'courses' => [],
            'galleries' => $event->galleries->map->toArray()->values()->all(),
            'videos' => $event->embeddableVideos->map->toArray()->values()->all(),
            'banner_image' => $event->getBannerImage(),
            'card_image' => $event->getCardImage(),
        ];
    }
}
