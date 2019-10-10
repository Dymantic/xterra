<?php

namespace App\Http\Controllers;

use App\Blog\Comment;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(Comment $comment)
    {
        $comment->addReply(request()->only('author', 'fb_id', 'body'));

        return $comment->translation->fresh()->comments->map->toArray();
    }
}
