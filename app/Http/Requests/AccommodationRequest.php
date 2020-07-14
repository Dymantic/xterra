<?php

namespace App\Http\Requests;

use App\Occasions\AccommodationInfo;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Foundation\Http\FormRequest;

class AccommodationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'        => [new AtLeastOneTranslation()],
            'description' => [new AtLeastOneTranslation()],
            'link'        => ['required', 'url'],
            'email'       => ['required_without:phone', 'email'],
            'phone'       => ['required_without:email'],
        ];
    }

    public function accommodationInfo(): AccommodationInfo
    {
        return new AccommodationInfo(
            $this->all([
                'name',
                'description',
                'link',
                'phone',
                'email',
            ])
        );
    }
}
