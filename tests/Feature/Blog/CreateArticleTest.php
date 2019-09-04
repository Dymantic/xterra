<?php


namespace Tests\Feature\Blog;


use App\Blog\Article;
use App\Blog\Translation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_an_article_with_a_translation()
    {
        $this->withoutExceptionHandling();

        $author = factory(User::class)->create(['name' => 'test author']);

        $response = $this->actingAs($author)->postJson("/admin/articles", [
            'lang' => 'en',
            'title' => 'test title'
        ]);
        $response->assertStatus(201);

        $this->assertCount(1, Article::all());
        $this->assertCount(1, Translation::all());

        $article = Article::first();
        $translation = Translation::first();

        $this->assertNotNull($article->slug);
        $this->assertEquals($article->id, $translation->article_id);
        $this->assertEquals('en', $translation->language);
        $this->assertEquals('test-title', $translation->slug);
        $this->assertEquals('test title', $translation->title);
        $this->assertEquals('test author', $translation->author_name);
    }

    /**
     *@test
     */
    public function the_lang_is_required()
    {
        $this->assertFieldIsInvalid(['lang' => '']);
    }

    /**
     *@test
     */
    public function the_lang_must_be_a_valid_lang_code()
    {
        $this->assertFieldIsInvalid(['lang' => 'what-is-this']);
    }

    /**
     *@test
     */
    public function the_title_is_required()
    {
        $this->assertFieldIsInvalid(['title' => '']);
    }

    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'lang' => 'en',
            'title' => 'test title'
        ];
        $response = $this->asAdmin()->postJson("/admin/articles", array_merge($valid, $field));
        $response->assertStatus(422);

        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}