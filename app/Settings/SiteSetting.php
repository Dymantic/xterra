<?php

namespace App\Settings;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $guarded = [];

    protected $casts = ['settings' => 'array'];

    public static function saveSetting($key, $value)
    {
        static::getInstance()->update(["settings->{$key}" => $value]);
    }

    public static function getSetting($key, $default = null)
    {
        return static::getInstance()->settings[$key] ?? $default;
    }

    private static function getInstance()
    {
        $settings = static::first();

        if(!$settings) {
            $settings = static::create(["settings" => []]);
        }

        return $settings;
    }
}
