<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TranslationRequired implements Rule
{

    private $required_languages;

    public function __construct(...$required_langs)
    {
        $this->required_languages = collect($required_langs);
    }


    public function passes($attribute, $value)
    {
        if(!is_array($value)) {
            return false;
        }

        foreach ($this->required_languages as $language) {
            if(!array_key_exists($language, $value) || !$value[$language]) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
