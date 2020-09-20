<?php


namespace Tests\Feature\Campaigns;


use App\Blog\Article;
use App\Campaigns\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignArticleToCampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function assign_a_blog_post_to_a_campaign()
    {
        $this->withoutExceptionHandling();

        $campaign = factory(Campaign::class)->create();
        $article = factory(Article::class)->create();

        $response = $this->asAdmin()->postJson("/admin/campaigns/{$campaign->id}/articles", [
            'article_id' => $article->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('article_campaign', [
            'article_id' => $article->id,
            'campaign_id' => $campaign->id,
        ]);
    }
}
