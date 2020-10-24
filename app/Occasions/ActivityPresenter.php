<?php


namespace App\Occasions;


use App\DatePresenter;

class ActivityPresenter
{

    public static function forPublic(Activity $activity, $lang)
    {
        $activity->load('fees', 'courses', 'event');
        $card_image = $activity->getFirstMedia(Activity::CARD_IMAGE);
        $banner_image = $activity->getFirstMedia(Activity::BANNER_IMAGE);
        $schedule = Schedule::forEvent($activity)->presentForLang($lang, $activity->date);
        $fees = $activity->fees->map->presentForLang($lang)->values()->all();
        $courses = $activity->courses->map->presentForLang($lang)->values()->all();
        $prizeHtml = $activity->prizesHtml($lang);
        $rulesHtml = $activity->rulesHtml($lang);
        $infoHtml = $activity->infoHtml($lang);

        return [
            'slug'                   => $activity->slug,
            'full_slug'              => '/top-secret/races/' . $activity->slug,
            'name'                   => $activity->name[$lang] ?? '',
            'category'               => $activity->category,
            'distance'               => $activity->distance[$lang] ?? '',
            'intro'                  => $activity->intro->in($lang),
            'description_html'       => $activity->descriptionHtml($lang),
            'location'               => $activity->event->location[$lang] ?? '',
            'venue_name'             => $activity->venue_name[$lang] ?? '',
            'venue_address'          => $activity->venue_address[$lang] ?? '',
            'date'                   => DatePresenter::pretty($activity->date),
            'map_link'               => $activity->map_link,
            'registration_link'      => $activity->registration_link,
            'is_race'                => $activity->is_race,
            'schedule'               => $schedule,
            'has_schedule'           => count($schedule) > 0,
            'prizes_html'            => $prizeHtml,
            'has_prizes'             => self::checkForHtml($prizeHtml),
            'fees'                   => $fees,
            'has_fees'               => count($fees) > 0,
            'courses'                => $courses,
            'has_courses'            => count($courses) > 0,
            'schedule_notes'         => $activity->schedule_notes[$lang] ?? '',
            'prize_notes'            => $activity->prize_notes[$lang] ?? '',
            'fees_notes'             => $activity->fees_notes[$lang] ?? '',
            'race_rules_document'    => $activity->rulesAndInfoDoc(),
            'zh_race_rules_document' => $activity->chineseRulesAndInfoDoc(),
            'athletes_guide'         => $activity->athletesGuide(),
            'zh_athletes_guide'      => $activity->chineseAthleteGuide(),
            'has_rules_and_info'     => self::checkForHtml($rulesHtml) && self::checkForHtml($infoHtml),
            'has_rules'     => self::checkForHtml($prizeHtml),
            'race_rules_html'        => $rulesHtml,
            'race_info_html'         => $infoHtml,
            'title_image'            => [
                'card'   => $card_image ? $card_image->getUrl('card') : Activity::DEFAULT_BANNER,
                'banner' => $banner_image ? $banner_image->getUrl('banner') : Activity::DEFAULT_BANNER,
            ],
            'video'                  => $activity->embeddableVideos()->latest()->first(),
        ];
    }

    public static function checkForHtml($html)
    {
        return trim($html) !== '<div class="admin-edited"></div>';
    }
}
