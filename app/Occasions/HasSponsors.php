<?php


namespace App\Occasions;


trait HasSponsors
{

    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }

    public function addSponsor(SponsorInfo $sponsorInfo): Sponsor
    {
        $next_position = optional($this->sponsors()->orderBy('position', 'desc')->first())->position;
        return $this->sponsors()->create(
            array_merge($sponsorInfo->toArray(), ['position' => $next_position ? $next_position + 1 : null])
        );
    }
}
