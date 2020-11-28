<?php


namespace App\People;


use App\Occasions\EventPresenter;
use Illuminate\Support\Str;

class CoachPresenter
{

    public static function forAdmin(Coach $coach): array
    {
        return [
            'id'             => $coach->id,
            'name'           => $coach->name->toArray(),
            'location'       => $coach->location->toArray(),
            'certifications' => $coach->certifications->toArray(),
            'experience'     => $coach->experience->toArray(),
            'philosophy'     => $coach->philosophy->toArray(),
            'email'          => $coach->email,
            'phone'          => $coach->phone,
            'website'        => $coach->website,
            'line'           => $coach->line,
            'social_links'   => $coach->getSocialLinks(),
            'profile_pic'    => $coach->getProfilePic(),
            'is_public'      => $coach->is_public,
            'videos'         => $coach->embeddableVideos->map->toArray()->values()->all(),
        ];
    }

    public static function forPublic(Coach $coach, $lang)
    {
        return [
            'slug'           => sprintf("/coaches/%s/%s", $coach->slug, Str::slug($coach->name->in('en'))),
            'name'           => $coach->name->in('en'),
            'location'       => $coach->location->in('en'),
            'certifications' => $coach->certifications->in('en'),
            'experience'     => $coach->experience->in('en'),
            'philosophy'     => $coach->philosophy->in('en'),
            'email'          => $coach->email,
            'phone'          => $coach->phone,
            'website'        => $coach->website,
            'line'           => $coach->line,
            'social_links'   => $coach->getSocialLinks(),
            'profile_pic'    => $coach->getProfilePic(),
            'videos'         => $coach->embeddableVideos->map->presentForLang($lang)->values()->all(),
            'events'         => $coach->events->map->presentForLang($lang)->values()->all(),
        ];
    }
}
