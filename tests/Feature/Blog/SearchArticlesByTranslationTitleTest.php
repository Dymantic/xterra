<?php


namespace Tests\Feature\Blog;


use App\Blog\Article;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchArticlesByTranslationTitleTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_articles_matching_search_query()
    {
        $this->withoutExceptionHandling();

        $matches_english = factory(Article::class)->create();
        factory(Translation::class)->create([
            'article_id' => $matches_english->id,
            'language' => 'en',
            'title' => 'This matches the query',
        ]);

        $matches_chinese = factory(Article::class)->create();
        factory(Translation::class)->create([
            'article_id' => $matches_chinese->id,
            'language' => 'zh',
            'title' => 'Querying is possible in either case',
        ]);

        $no_match = factory(Article::class)->create();
        factory(Translation::class)->create(['article_id' => $no_match->id]);

        $response = $this->asAdmin()->getJson("/admin/search/articles?query=query");
        $response->assertStatus(200);

        $this->assertCount(2, $response->decodeResponseJson());

        $expected = [$matches_english->toArray(), $matches_chinese->toArray()];

        $this->assertEquals($expected, $response->decodeResponseJson());
    }
}