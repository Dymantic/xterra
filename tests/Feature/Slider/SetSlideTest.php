<?php

namespace Tests\Feature\Slider;

use App\Blog\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetSlideTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_a_slide_for_the_slider()
    {
        $this->withoutExceptionHandling();
        $article = factory(Article::class)->create();

        $response = $this->asAdmin()->postJson("/admin/slider/slides", [
            'position' => 1,
            'article_id' => $article->id,
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('slides', [
            'position' => 1,
            'article_id' => $article->id,
        ]);
    }

    /**
     *@test
     */
    public function the_position_is_required()
    {
        $article = factory(Article::class)->create();

        $response = $this->asAdmin()->postJson("/admin/slider/slides", [
            'article_id' => $article->id,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('position');
    }

    /**
     *@test
     */
    public function the_position_must_be_an_integer()
    {
        $article = factory(Article::class)->create();

        $response = $this->asAdmin()->postJson("/admin/slider/slides", [
            'position' => 'not-an-integer',
            'article_id' => $article->id,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('position');
    }

    /**
     *@test
     */
    public function the_position_must_positive()
    {
        $article = factory(Article::class)->create();

        $response = $this->asAdmin()->postJson("/admin/slider/slides", [
            'position' => -1,
            'article_id' => $article->id,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('position');
    }

    /**
     *@test
     */
    public function the_article_id_is_required()
    {
        $response = $this->asAdmin()->postJson("/admin/slider/slides", [
            'position' => 1,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('article_id');
    }

    /**
     *@test
     */
    public function the_article_is_must_exist_in_the_db()
    {
        $response = $this->asAdmin()->postJson("/admin/slider/slides", [
            'position' => 1,
            'article_id' => 99,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('article_id');
    }
}