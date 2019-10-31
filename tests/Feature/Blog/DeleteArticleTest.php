<?php


namespace Tests\Feature\Blog;


use App\Blog\Article;
use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_article()
    {
        $this->withoutExceptionHandling();

        $article = factory(Article::class)->create();
        $en_trans = factory(Translation::class)
            ->state('en')
            ->create(['article_id' => $article->id]);
        $zh_trans = factory(Translation::class)
            ->state('zh')
            ->create(['article_id' => $article->id]);

        $response = $this->asAdmin()->deleteJson("/admin/articles/{$article->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
        $this->assertDatabaseMissing('translations', ['id' => $en_trans->id]);
        $this->assertDatabaseMissing('translations', ['id' => $zh_trans->id]);
    }
}
