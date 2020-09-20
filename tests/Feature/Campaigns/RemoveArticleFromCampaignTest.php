<?php


namespace Tests\Feature\Campaigns;


use App\Blog\Article;
use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveArticleFromCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_an_article_from_a_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $article = factory(Article::class)->create();
        $campaign->attachArticle($article);

        $response = $this
            ->asAdmin()
            ->deleteJson("/admin/campaigns/{$campaign->id}/articles/{$article->id}");

        $response->assertSuccessful();

        $this->assertDatabaseMissing('article_campaign', [
            'article_id' => $article->id,
            'campaign_id' => $campaign->id,
        ]);
    }
}
