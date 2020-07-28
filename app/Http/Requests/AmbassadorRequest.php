<?php

namespace App\Http\Requests;

use App\People\AmbassadorInfo;
use App\People\SocialLink;
use App\Rules\NonEmptyTranslation;
use App\Rules\Translation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AmbassadorRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => [new NonEmptyTranslation()],
            'about' => [new Translation()],
            'achievements' => [new Translation()],
            'collaboration' => [new Translation()],
            'philosophy' => [new Translation()],
            'social_links' => ['array'],
            'social_links.*.platform' => ['required', Rule::in(SocialLink::ALLOWED_PLATFORMS)],
            'social_links.*.link' => ['required'],
        ];
    }

    public function ambassadorInfo(): AmbassadorInfo
    {
        return new AmbassadorInfo($this->all([
            'name',
            'about',
            'achievements',
            'collaboration',
            'philosophy',
            'social_links',
        ]));
    }
}
