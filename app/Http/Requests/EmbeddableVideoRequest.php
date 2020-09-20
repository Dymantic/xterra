<?php

namespace App\Http\Requests;

use App\Rules\NonEmptyTranslation;
use App\Translation;
use Illuminate\Foundation\Http\FormRequest;

class EmbeddableVideoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'video_id' => ['required'],
            'title' => [new NonEmptyTranslation()],
        ];
    }

    public function videoTitle(): Translation
    {
        return new Translation($this->get('title'));
    }
}
