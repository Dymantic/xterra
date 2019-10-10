<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function index()
    {
        return Tag::withCount('translations')
                  ->get()->map->toArrayWithCount();
    }

    public function destroy()
    {
        request()->validate([
            'tag_ids' => ['required', 'array'],
            'tag_ids.*' => ['integer']
        ]);
        Tag::whereIn('id', request('tag_ids'))->delete();
    }
}
