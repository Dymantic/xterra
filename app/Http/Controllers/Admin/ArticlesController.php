<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ArticlesController extends Controller
{

    public function index()
    {
        return Article::with('categories', 'translations', 'translations.tags')
                      ->latest()
                      ->get()
            ->map->toArray();
    }

    public function store()
    {
        request()->validate([
            'lang'  => ['required', Rule::in(['en', 'zh'])],
            'title' => ['required']
        ]);

        return Article::makeWithTranslation(request('lang'), request('title'), auth()->user());
    }

    public function destroy(Article $article)
    {
        $article->safeDelete();
    }
}
