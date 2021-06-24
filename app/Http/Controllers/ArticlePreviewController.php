<?php

namespace App\Http\Controllers;

use App\Blog\Article;
use App\Blog\Category;
use App\Blog\Translation;
use Illuminate\Http\Request;

class ArticlePreviewController extends Controller
{
    public function show(Article $article, Translation $translation)
    {

        if(!$article->translations->contains($translation)) {
            abort(404);
        }

        $formatted = $translation->toArray();
        $formatted['related_posts'] = $translation->related($translation->language)->map->toArray();
        $formatted['alternatives'] = [];


        return view('front.blog.show', [
            'article' => $formatted,
            'categories' => Category::all()->map(function($cat) {
                return [
                    'slug' => $cat->slug,
                    'name' => $cat->title[app()->getLocale()]
                ];
            })->all(),
            'in_requested_lang' => true,
        ]);
    }
}
