<?php

namespace App\Http\Requests;

use App\Occasions\Activity;
use App\Occasions\ActivityInfo;
use App\Rules\AtLeastOneTranslation;
use App\Rules\TranslationArray;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => [new AtLeastOneTranslation],
            'category' => ['required', Rule::in(Activity::ACTIVITY_TYPES)],
            'date' => ['date', 'nullable'],
            'venue_name' => [new TranslationArray()],
            'venue_address' => [new TranslationArray()],
            'map_link' => ['url', 'nullable'],
            'registration_link' => ['url', 'nullable'],
        ];
    }

    public function raceInfo(): ActivityInfo
    {
        return ActivityInfo::forRace($this->all([
            'name',
            'distance',
            'intro',
            'category',
            'venue_address',
            'venue_name',
            'date',
            'map_link',
            'registration_link',
        ]));
    }

    public function activityInfo(): ActivityInfo
    {
        return ActivityInfo::forActivity($this->all([
            'name',
            'distance',
            'intro',
            'category',
            'venue_name',
            'venue_address',
            'map_link',
            'registration_link',
        ]));
    }
}
