<?php

namespace App\Http\Requests;

use App\Occasions\Activity;
use App\Occasions\ActivityInfo;
use App\Rules\AtLeastOneTranslation;
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
        ];
    }

    public function raceInfo(): ActivityInfo
    {
        return ActivityInfo::forRace($this->all([
            'name',
            'distance',
            'description',
            'category',
        ]));
    }

    public function activityInfo(): ActivityInfo
    {
        return ActivityInfo::forActivity($this->all([
            'name',
            'distance',
            'description',
            'category',
        ]));
    }
}
