<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleCategoriesController extends Controller
{
    public function update(Article $article)
    {
        request()->validate([
            'category_ids' => ['array'],
            'category_ids.*' => ['exists:categories,id']
        ]);

        $article->categories()->sync(request('category_ids'));
    }
}
