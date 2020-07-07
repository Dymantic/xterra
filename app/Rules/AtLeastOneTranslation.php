<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AtLeastOneTranslation implements Rule
{


    public function passes($attribute, $value)
    {
        $has_en = isset($value['en']) && (!empty($value['en']));
        $has_zh = isset($value['en']) && (!empty($value['en']));

        return $has_en || $has_zh;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute requires at least either an English or a Chinese value.';
    }
}
