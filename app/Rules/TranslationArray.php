<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TranslationArray implements Rule
{

    public function __construct()
    {

    }


    public function passes($attribute, $value)
    {
        return is_array($value) && array_key_exists('en', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute should be a translation';
    }
}
