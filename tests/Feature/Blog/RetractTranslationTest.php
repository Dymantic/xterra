<?php


namespace Tests\Feature\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetractTranslationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function retract_a_translation()
    {
        $this->withoutExceptionHandling();

        $translation = factory(Translation::class)->state('published')->create();

        $response = $this
            ->asAdmin()
            ->deleteJson("/admin/published-translations/{$translation->id}");
        $response->assertStatus(200);

        $this->assertFalse($translation->fresh()->is_published);
    }
}