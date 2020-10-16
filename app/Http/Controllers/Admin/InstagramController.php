<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Dymantic\InstagramFeed\Profile;
use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function show()
    {
        $profile = Profile::where('username', 'xterra')->first();

        return [
            'auth_url' => $profile->getInstagramAuthUrl(),
            'feed' => $profile->feed(),
            'has_auth' => $profile->hasInstagramAccess(),
        ];
    }
}
