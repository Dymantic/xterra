<?php


namespace App\People;


use Illuminate\Support\Str;

class AmbassadorPresenter
{

    public static function forAdmin(Ambassador $ambassador): array
    {
        return [
            'id'            => $ambassador->id,
            'name'          => $ambassador->name->toArray(),
            'about'         => $ambassador->about->toArray(),
            'achievements'  => $ambassador->achievements->toArray(),
            'collaboration' => $ambassador->collaboration->toArray(),
            'philosophy'    => $ambassador->philosophy->toArray(),
            'social_links'  => $ambassador->getSocialLinks(),
            'profile_pic'   => $ambassador->getProfilePic(),
            'is_public'     => $ambassador->is_public,
            'videos'        => $ambassador->embeddableVideos->map->toArray()->values()->all(),
        ];
    }

    public static function forPublic(Ambassador $ambassador, $lang)
    {
        return [
            'slug'          => sprintf("/ambassadors/%s/%s", $ambassador->slug, Str::slug($ambassador->name->in('en'))),
            'name'          => $ambassador->name->in($lang),
            'about'         => $ambassador->about->in($lang),
            'achievements'  => $ambassador->achievements->in($lang),
            'collaboration' => $ambassador->collaboration->in($lang),
            'philosophy'    => $ambassador->philosophy->in($lang),
            'social_links'  => $ambassador->getSocialLinks(),
            'profile_pic'   => $ambassador->getProfilePic(),
            'videos'        => $ambassador->embeddableVideos->map->presentForLang($lang)->values()->all(),
            'events'        => $ambassador->events->map->presentForLang($lang)->values()->all(),
        ];
    }
}
