<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\People\Ambassador;
use Illuminate\Http\Request;

class AmbassadorProfilePicController extends Controller
{
    public function store(Ambassador $ambassador)
    {
        request()->validate([
            'image' => ['required', 'image'],
        ]);

        $ambassador->setProfilePic(request('image'));
    }

    public function destroy(Ambassador $ambassador)
    {
        $ambassador->clearProfilePic();
    }
}
