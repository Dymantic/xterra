<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleSearchController extends Controller
{
    public function index()
    {
        $search = request('query');

        if(!$search) {
            return [];
        }

        $articles = Article::whereHas('translations', function($query) use ($search) {
            return $query->where('title', 'LIKE', "%{$search}%");
        })->with('translations', 'categories')->get();

        return $articles->map->toArray();

    }
}
