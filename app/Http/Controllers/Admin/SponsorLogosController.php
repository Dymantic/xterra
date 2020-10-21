<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Sponsor;
use Illuminate\Http\Request;

class SponsorLogosController extends Controller
{
    public function store(Sponsor $sponsor)
    {
        request()->validate([
            'image' => ['image'],
        ]);

        $sponsor->setLogo(request('image'));
    }

    public function destroy(Sponsor $sponsor)
    {
        $sponsor->clearLogo();
    }
}
