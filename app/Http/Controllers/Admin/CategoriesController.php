<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

    public function store()
    {
        request()->validate([
            'title' => ['required', 'array'],
            'title.en' => ['required']
        ]);

        return Category::create(['title' => request('title')]);
    }

    public function update(Category $category)
    {
        request()->validate([
            'title' => ['required', 'array'],
            'title.en' => ['required']
        ]);

        $category->update(['title' => request('title')]);
    }

    public function destroy(Category $category)
    {
        $category->safeDelete();
    }
}
