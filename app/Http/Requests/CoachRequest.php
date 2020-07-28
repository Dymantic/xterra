<?php

namespace App\Http\Requests;

use App\People\CoachInfo;
use App\People\SocialLink;
use App\Rules\NonEmptyTranslation;
use App\Rules\Translation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CoachRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                    => [new NonEmptyTranslation()],
            'location'                => [new Translation()],
            'certifications'          => [new Translation()],
            'experience'              => [new Translation()],
            'philosophy'              => [new Translation()],
            'email'                   => ['email', 'nullable'],
            'website'                 => ['url', 'nullable'],
            'social_links'            => ['array'],
            'social_links.*.platform' => ['required', Rule::in(SocialLink::ALLOWED_PLATFORMS)],
            'social_links.*.link'     => ['required'],
        ];
    }

    public function coachInfo(): CoachInfo
    {
        return new CoachInfo($this->all([
            'name',
            'location',
            'certifications',
            'experience',
            'philosophy',
            'email',
            'phone',
            'website',
            'line',
            'social_links'
        ]));
    }
}
