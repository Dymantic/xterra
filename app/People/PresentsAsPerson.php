<?php


namespace App\People;


use Illuminate\Support\Str;

trait PresentsAsPerson
{
    public function presentForPersonCard($lang)
    {
        return [
            'name'        => $this->name->in($lang),
            'type'        => $this instanceof Ambassador ? trans('people.ambassador') : trans('people.coach'),
            'category'        => $this instanceof Ambassador ? 'ambassador' : 'coach',
            'profile_pic' => $this->getProfilePic()['thumb'],
            'slug'        => sprintf("/%s/%s/%s", $this instanceof Ambassador ? 'ambassadors' : 'coaches',
                $this->slug, Str::slug($this->name->in('en'))),
        ];
    }
}
