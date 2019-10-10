<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleTitleImageController extends Controller
{
    public function store(Article $article)
    {
        request()->validate([
            'image' => ['required', 'image'],
        ]);

        $image = $article->setTitleImage(request('image'));

        return ['image_src' => $image->getUrl('thumb')];
    }
}
