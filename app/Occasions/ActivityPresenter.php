<?php


namespace App\Occasions;


use App\DatePresenter;

class ActivityPresenter
{

    public static function forPublic(Activity $activity, $lang)
    {
        $activity->load('fees', 'courses');
        $card_image = $activity->getFirstMedia(Activity::CARD_IMAGE);
        $banner_image = $activity->getFirstMedia(Activity::BANNER_IMAGE);

        return [
            'name'                   => $activity->name[$lang] ?? '',
            'category'               => $activity->category,
            'distance'               => $activity->distance[$lang] ?? '',
            'intro'                  => $activity->intro->in($lang),
            'description_html'       => $activity->descriptionHtml($lang),
            'venue_name'             => $activity->venue_name[$lang] ?? '',
            'venue_address'          => $activity->venue_address[$lang] ?? '',
            'date'                   => DatePresenter::pretty($activity->date),
            'map_link'               => $activity->map_link,
            'registration_link'      => $activity->registration_link,
            'is_race'                => $activity->is_race,
            'schedule'               => Schedule::forEvent($activity)->toArray(),
            'prizes_html'            => $activity->prizesHtml($lang),
            'fees'                   => $activity->fees->map->toArray()->values()->all(),
            'courses'                => $activity->courses->map->toArray()->values()->all(),
            'schedule_notes'         => $activity->schedule_notes[$lang] ?? '',
            'prize_notes'            => $activity->prize_notes[$lang] ?? '',
            'fees_notes'             => $activity->fees_notes[$lang] ?? '',
            'race_rules_document'    => $activity->rulesAndInfoDoc(),
            'zh_race_rules_document' => $activity->chineseRulesAndInfoDoc(),
            'athletes_guide'         => $activity->athletesGuide(),
            'zh_athletes_guide'      => $activity->chineseAthleteGuide(),
            'race_rules_html'        => $activity->rulesHtml($lang),
            'race_info_html'         => $activity->infoHtml($lang),
            'title_image'            => [
                'card'   => $card_image ? $card_image->getUrl('card') : Activity::DEFAULT_IMAGE,
                'banner' => $banner_image ? $banner_image->getUrl('banner') : Activity::DEFAULT_IMAGE,
            ],
            'video'                  => $activity->embeddableVideos()->latest()->first(),
        ];
    }
}
