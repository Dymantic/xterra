<?php

namespace App\People;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    const YOUTUBE = 'youtube';
    const INSTAGRAM = 'instagram';
    const LINKDIN = 'linkdin';
    const FACEBOOK = 'facebook';

    const ALLOWED_PLATFORMS = [
        self::YOUTUBE,
        self::INSTAGRAM,
        self::LINKDIN,
        self::FACEBOOK,
    ];

    protected $fillable = ['platform', 'link'];
}
