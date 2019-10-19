<?php

namespace App\Http\Controllers;

use App\Blog\Reply;
use Illuminate\Http\Request;

class FlaggedRepliesController extends Controller
{
    public function store()
    {
        request()->validate([
            'flaggable_id' => ['required', 'exists:replies,id'],
            'reason' => ['required'],
        ]);

        Reply::find(request('flaggable_id'))
             ->flag(request('reason'));

    }
}
