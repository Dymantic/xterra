<?php

namespace App\Http\Requests;

use App\Rules\NonEmptyTranslation;
use App\Rules\Translation;
use App\Shop\PromotionInfo;
use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => [new NonEmptyTranslation()],
            'writeup' => [new Translation()],
            'button_text' => [new Translation()],
            'link' => ['url', 'nullable'],
        ];
    }

    public function promotionInfo(): PromotionInfo
    {
        return new PromotionInfo($this->all([
            'title', 'writeup', 'link', 'button_text'
        ]));
    }
}
