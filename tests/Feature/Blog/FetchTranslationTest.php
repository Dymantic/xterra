<?php


namespace Tests\Feature\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchTranslationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_existing_translation()
    {
        $this->withoutExceptionHandling();

        $translation = factory(Translation::class)->create();

        $response = $this->asAdmin()->getJson("/admin/translations/{$translation->id}");
        $response->assertStatus(200);

        $this->assertEquals($translation->toArray(), $response->json());
    }
}
