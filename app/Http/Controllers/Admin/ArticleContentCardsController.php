<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Article;
use App\Http\Controllers\Controller;
use App\Media\ContentCard;
use App\Media\ContentCardInfo;
use App\Translation;
use Illuminate\Http\Request;

class ArticleContentCardsController extends Controller
{
    public function store()
    {
        $article = Article::with('translations')->findOrFail(request('article_id'));

        ContentCard::fromExistingContent($article);

//        $cardInfo = new ContentCardInfo([
//            'category' => ['en' => 'blog', 'zh' => '博客'],
//            'title'    => [
//                'en' => $article->translations->first(fn($t) => $t->language === 'en')->title,
//                'zh' => $article->translations->first(fn($t) => $t->language === 'zh')->title
//            ],
//            'link'     => "/blog/{$article->slug}/",
//        ]);
//
//        ContentCard::new($cardInfo);
    }
}
