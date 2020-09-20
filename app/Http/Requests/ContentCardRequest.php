<?php

namespace App\Http\Requests;

use App\Media\ContentCardInfo;
use App\Rules\AtLeastOneTranslation;
use App\Rules\TranslationArray;
use Illuminate\Foundation\Http\FormRequest;

class ContentCardRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [new AtLeastOneTranslation()],
            'category' => [new TranslationArray()],
        ];
    }

    public function contentCardInfo(): ContentCardInfo
    {
        return new ContentCardInfo($this->all([
            'title',
            'category',
            'link',
        ]));
    }
}
