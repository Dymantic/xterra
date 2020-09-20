<?php

namespace App\Http\Controllers\Admin;

use App\Blog\Article;
use App\Campaigns\Campaign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignArticlesController extends Controller
{
    public function store(Campaign $campaign)
    {
        $campaign->attachArticle(
            Article::findOrFail(request('article_id'))
        );
    }

    public function destroy(Campaign $campaign, Article $article)
    {
        $campaign->removeArticle($article);
    }
}
