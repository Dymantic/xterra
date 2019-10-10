<?php


namespace Tests\Feature\Slider;


use App\Blog\Article;
use App\Slider\Slider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchSetSlidesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_currently_set_slides()
    {
        $this->withoutExceptionHandling();

        $articleA = factory(Article::class)->create();
        $articleB = factory(Article::class)->create();

        Slider::setSlide(['position' => 1, 'article_id' => $articleA->id]);
        Slider::setSlide(['position' => 2, 'article_id' => $articleB->id]);

        $response = $this->asAdmin()->getJson("/admin/slider/slides");
        $response->assertStatus(200);

        $this->assertEquals(Slider::getSetSlides(), $response->decodeResponseJson());
    }
}