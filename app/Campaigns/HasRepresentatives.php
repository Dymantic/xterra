<?php


namespace App\Campaigns;


use App\People\Ambassador;
use App\People\Coach;

trait HasRepresentatives
{

    public function ambassadors()
    {
        return $this->morphedByMany(Ambassador::class, 'representative');
    }

    public function coaches()
    {
        return $this->morphedByMany(Coach::class, 'representative');
    }
}
