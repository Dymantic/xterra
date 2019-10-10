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
    public function create_new_category()
    {
        $all = Category::createNew([
            'title' => ['en' => 'en title', 'zh' => 'zh title'],
            'description' => ['en' => 'en description', 'zh' => 'zh description'],
        ]);
        $en_only = Category::createNew([
            'title' => ['en' => 'en title'],
            'description' => ['en' => 'en description'],
        ]);

        $zh_only = Category::createNew([
            'title' => ['en' => 'en title', 'zh' => 'zh title'],
            'description' => ['zh' => 'zh description'],
        ]);

        $extra = Category::createNew([
            'title' => ['en' => 'en title', 'zh' => 'zh title', 'fr' => 'fr title'],
            'description' => ['en' => 'en description', 'zh' => 'zh description'],
        ]);

        $this->assertEquals(['en' => 'en title', 'zh' => 'zh title'], $all->title);
        $this->assertEquals(['en' => 'en description', 'zh' => 'zh description'], $all->description);

        $this->assertEquals(['en' => 'en title', 'zh' => ''], $en_only->title);
        $this->assertEquals(['en' => 'en description', 'zh' => ''], $en_only->description);

        $this->assertEquals(['en' => 'en title', 'zh' => 'zh title'], $zh_only->title);
        $this->assertEquals(['en' => '', 'zh' => 'zh description'], $zh_only->description);

        $this->assertEquals(['en' => 'en title', 'zh' => 'zh title'], $extra->title);
        $this->assertEquals(['en' => 'en description', 'zh' => 'zh description'], $extra->description);
    }

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