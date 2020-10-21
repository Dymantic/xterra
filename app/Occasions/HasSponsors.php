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
        return $this->sponsors()->create($sponsorInfo->toArray());
    }
}
