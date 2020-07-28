<?php


namespace App;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Translation implements CastsAttributes
{

    public $translations;

    public function __construct(array $translations = [])
    {
        $this->translations = $translations;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        return new self(json_decode($value, true) ?? []);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value->toArray());
    }

    public function toArray(): array
    {
        return array_merge([
            'en' => '',
            'zh' => ''
        ], $this->translations);
    }

    public function in(string $locale): string
    {
        return $this->translations[$locale] ?? '';
    }

    public function __toString(): string
    {
        return $this->translations[app()->getLocale()] ?? '';
    }
}
