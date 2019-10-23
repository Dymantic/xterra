<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Blog\Category;
use App\Blog\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TranslationPreviewController extends Controller
{
    public function show(Translation $translation)
    {
        $preview = $translation->toArray();
        $preview['related_posts'] = $translation->related($translation->language)->map->toArray();

        return view('front.blog.show', [
            'article' => $preview,
            'in_requested_lang' => true,
            'categories' => Category::all()->map(function($cat) {
                return [
                    'slug' => $cat->slug,
                    'name' => $cat->title[app()->getLocale()]
                ];
            })->all(),
        ]);
    }
}
