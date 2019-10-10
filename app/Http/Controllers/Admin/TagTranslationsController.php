<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagTranslationsController extends Controller
{
    public function index(Tag $tag)
    {
        return $tag->translations->map->toArray();
    }
}
