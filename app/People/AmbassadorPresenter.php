<?php


namespace App\People;


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
            'social_links' => $ambassador->getSocialLinks(),
            'profile_pic'   => $ambassador->getProfilePic(),
            'is_public'     => $ambassador->is_public,
            'videos'        => $ambassador->embeddableVideos->map->toArray()->values()->all(),
        ];
    }
}
