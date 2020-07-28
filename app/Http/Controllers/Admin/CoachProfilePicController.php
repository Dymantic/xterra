<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\People\Coach;
use Illuminate\Http\Request;

class CoachProfilePicController extends Controller
{
    public function store(Coach $coach)
    {
        request()->validate([
            'image' => ['required', 'image'],
        ]);

        $coach->setProfilePic(request('image'));
    }

    public function destroy(Coach $coach)
    {
        $coach->clearProfilePic();
    }
}
