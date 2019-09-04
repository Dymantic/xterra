<?php


namespace Tests\Unit\Blog;


use App\Blog\Article;
use App\Blog\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function safe_deleting_a_category_removes_entries_from_pivot()
    {
        $category = factory(Category::class)->create();
        $article = factory(Article::class)->create();

        $article->categories()->sync([$category->id]);

        $this->assertCount(1, $article->fresh()->categories);

        $category->safeDelete();

        $this->assertCount(0, $article->fresh()->categories);
    }
}