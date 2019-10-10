<?php


namespace Tests\Feature\Slider;


use App\Blog\Article;
use App\Slider\Slider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveSlideTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_a_slide()
    {
        $this->withoutExceptionHandling();

        $article = factory(Article::class)->create();
        $position = 3;
        $slide = Slider::setSlide(['position' => $position, 'article_id' => $article->id]);

        $response = $this->asAdmin()->deleteJson("/admin/slider/{$position}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('slides', ['position' => 1]);
    }
}