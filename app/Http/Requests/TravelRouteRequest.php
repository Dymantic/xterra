<?php

namespace App\Http\Requests;

use App\Occasions\RouteInfo;
use App\Rules\AtLeastOneTranslation;
use Illuminate\Foundation\Http\FormRequest;

class TravelRouteRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => [new AtLeastOneTranslation()],
            'description' => [new AtLeastOneTranslation()],
        ];
    }

    public function routeInfo(): RouteInfo
    {
        return new RouteInfo($this->all(['name', 'description']));
    }
}
