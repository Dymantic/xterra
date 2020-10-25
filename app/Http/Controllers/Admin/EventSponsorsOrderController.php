<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Sponsor;
use Illuminate\Http\Request;

class EventSponsorsOrderController extends Controller
{
    public function store()
    {
        request()->validate([
            'sponsor_ids' => ['required', 'array'],
            'sponsor_ids.*' => ['exists:sponsors,id']
        ]);

        Sponsor::setOrder(request('sponsor_ids'));
    }
}
