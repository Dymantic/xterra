<?php

namespace App\Rules;

use App\Blog\Article;
use Illuminate\Contracts\Validation\Rule;

class UnusedTranslation implements Rule
{
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function passes($attribute, $value)
    {
        return ! $this->article->translations->pluck('language')->contains($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A translation for this language already exists.';
    }
}
