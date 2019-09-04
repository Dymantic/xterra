<?php


namespace Tests\Feature\Blog;


use App\Blog\Article;
use App\Blog\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignCategoriesToArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_categories_on_article()
    {
        $this->withoutExceptionHandling();

        $article = factory(Article::class)->create();

        $categoryA = factory(Category::class)->create();
        $categoryB = factory(Category::class)->create();

        $response = $this->asAdmin()->postJson("/admin/articles/{$article->id}/categories", [
            'category_ids' => [$categoryA->id, $categoryB->id],
        ]);
        $response->assertStatus(200);

        $this->assertTrue($article->fresh()->categories->contains($categoryA));
        $this->assertTrue($article->fresh()->categories->contains($categoryB));
    }

    /**
     *@test
     */
    public function category_ids_is_required()
    {
        $article = factory(Article::class)->create();

        $response = $this->asAdmin()->postJson("/admin/articles/{$article->id}/categories", [
            'category_ids' => null,
        ]);
        $response->assertStatus(422);
    }

    /**
     *@test
     */
    public function an_empty_array_is_fine()
    {
        $article = factory(Article::class)->create();

        $response = $this->asAdmin()->postJson("/admin/articles/{$article->id}/categories", [
            'category_ids' => [],
        ]);
        $response->assertStatus(200);

        $this->assertCount(0, $article->fresh()->categories);
    }

    /**
     *@test
     */
    public function category_ids_must_exist_in_categories_table()
    {
        $article = factory(Article::class)->create();
        $this->assertNull(Category::find(88));

        $response = $this->asAdmin()->postJson("/admin/articles/{$article->id}/categories", [
            'category_ids' => [88],
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('category_ids.0');
    }
}