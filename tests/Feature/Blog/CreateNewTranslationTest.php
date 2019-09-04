<?php


namespace Tests\Feature\Blog;


use App\Blog\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateNewTranslationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_new_translation_for_article()
    {
        $this->withoutExceptionHandling();

        $article = factory(Article::class)->create();
        $author = factory(User::class)->create(['name' => 'test author']);

        $response = $this
            ->actingAs($author)
            ->postJson("/admin/articles/{$article->id}/translations", [
                'lang' => 'zh',
                'title'    => 'test title zh',
            ]);
        $response->assertStatus(201);

        $this->assertDatabaseHas('translations', [
            'article_id'  => $article->id,
            'author_name' => 'test author',
            'language'    => 'zh',
            'title'       => 'test title zh',
        ]);

    }

    /**
     *@test
     */
    public function the_language_is_required()
    {
        $this->assertFieldIsInvalid(['lang' => '']);
    }

    /**
     *@test
     */
    public function the_lang_must_be_a_recognized_value()
    {
        $this->assertFieldIsInvalid(['lang' => 'not-a-valid-lang']);
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
        $article = factory(Article::class)->create();
        $author = factory(User::class)->create(['name' => 'test author']);
        $valid = [
            'lang' => 'zh',
            'title'    => 'test title zh',
        ];

        $response = $this
            ->actingAs($author)
            ->postJson("/admin/articles/{$article->id}/translations", array_merge($valid, $field));
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}