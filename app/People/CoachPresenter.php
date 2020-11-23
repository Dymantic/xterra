<?php


namespace App\People;


class CoachPresenter
{

    public static function forAdmin(Coach $coach): array
    {
        return [
            'id' => $coach->id,
            'name' => $coach->name->toArray(),
            'location' => $coach->location->toArray(),
            'certifications' => $coach->certifications->toArray(),
            'experience' => $coach->experience->toArray(),
            'philosophy' => $coach->philosophy->toArray(),
            'email' => $coach->email,
            'phone' => $coach->phone,
            'website' => $coach->website,
            'line' => $coach->line,
            'social_links' => $coach->getSocialLinks(),
            'profile_pic'   => $coach->getProfilePic(),
            'is_public'     => $coach->is_public,
            'videos'        => $coach->embeddableVideos->map->toArray()->values()->all(),
        ];
    }
}
