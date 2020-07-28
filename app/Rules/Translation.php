<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Translation implements Rule
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

        return array_key_exists('en', $value) && array_key_exists('zh', $value);
    }


    public function message()
    {
        return 'The validation error message.';
    }
}
