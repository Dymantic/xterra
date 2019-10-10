<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

    public function index()
    {
        return Category::withCount('articles')->get();
    }

    public function store()
    {
        request()->validate([
            'title' => ['required', 'array'],
            'title.en' => ['required']
        ]);

        return Category::createNew(request()->only('title', 'description'));
    }

    public function update(Category $category)
    {
        request()->validate([
            'title' => ['required', 'array'],
            'title.en' => ['required']
        ]);

        $category->update(['title' => request('title'), 'description' => request('description')]);
    }

    public function destroy(Category $category)
    {
        $category->safeDelete();
    }
}
