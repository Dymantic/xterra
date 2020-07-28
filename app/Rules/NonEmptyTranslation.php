<?php

namespace App\Rules;

use App\Translation;
use Illuminate\Contracts\Validation\Rule;

class NonEmptyTranslation implements Rule
{

    public function __construct()
    {
        //
    }


    public function passes($attribute, $value)
    {
        if(!is_array($value)) {
            return false;
        }

        $translation = new Translation($value);

        if($translation->in('en') === '' && $translation->in('zh') === '') {
            return false;
        }

        return true;

    }


    public function message()
    {
        return ':attribute is required in at least one language';
    }
}
