<?php


namespace Tests\Unit\Blog;


use App\Blog\Article;
use App\Blog\Translation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function make_article_with_translation()
    {
        $author = factory(User::class)->create(['name' => 'test author']);
        $article = Article::makeWithTranslation('en', 'test title', $author);

        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals(Carbon::today()->format('Y-m-d'), $article->slug);
        $this->assertCount(1, $article->translations);

        $translation = $article->translations()->first();
        $this->assertInstanceOf(Translation::class, $translation);
        $this->assertEquals('en', $translation->language);
        $this->assertEquals('test title', $translation->title);
        $this->assertEquals('test-title', $translation->slug);
        $this->assertEquals('test author', $translation->author_name);
    }

    /**
     *@test
     */
    public function articles_mage_on_same_day_have_unique_slugs()
    {
        $author = factory(User::class)->create(['name' => 'test author']);
        $articleA = Article::makeWithTranslation('en', 'one title', $author);
        $articleB = Article::makeWithTranslation('en', 'another title', $author);

        $this->assertNotEquals($articleA->slug, $articleB->slug);
    }
}