<?php

namespace App\Http\Controllers;

use App\Blog\Translation;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function index(Translation $translation)
    {
        return $translation->comments()->with('replies', 'flagged', 'replies.flagged')->latest()->get()->map->toArray();
    }

    public function store(Translation $translation)
    {
        request()->validate([
            'author' => ['required'],
            'fb_id' => ['required'],
            'body' => ['required'],
        ]);

        $translation->addComment(request()->only('author', 'fb_id', 'body'));

        return $translation->fresh()->comments()->with('replies')->latest()->get()->map->toArray();
    }
}
