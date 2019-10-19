<?php

namespace App\Http\Controllers\Admin;

use App\Blog\FlaggedComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlaggedCommentsController extends Controller
{

    public function index()
    {
        return FlaggedComment::with('flaggable')->latest()->get()->map->toArray();
    }

}
