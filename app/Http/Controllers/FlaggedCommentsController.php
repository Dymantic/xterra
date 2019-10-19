<?php

namespace App\Http\Controllers;

use App\Blog\Comment;
use App\Blog\FlaggedComment;
use Illuminate\Http\Request;

class FlaggedCommentsController extends Controller
{
    public function store()
    {
        request()->validate([
            'flaggable_id' => ['required', 'exists:comments,id'],
            'reason'     => ['required']
        ]);

        Comment::find(request('flaggable_id'))
               ->flag(request('reason'));
    }
}
