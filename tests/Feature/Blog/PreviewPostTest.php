<?php


namespace Tests\Feature\Blog;


use App\Blog\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PreviewPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_draft_translation_can_be_previewed_by_admin()
    {
        $this->withoutExceptionHandling();

        $translation = factory(Translation::class)->state('draft')->create();

        $response = $this->asAdmin()->get("/admin/pages/previews/{$translation->id}");
        $response->assertStatus(200);

        $response_data = $response->original->getData()['article'];
        $translation_data = $translation->toArray();

        collect($translation_data)->each(function($value, $key) use ($response_data) {
           $this->assertArrayHasKey($key, $response_data);
           $this->assertEquals($value, $response_data[$key]);
        });
    }

    /**
     *@test
     */
    public function a_translation_cannot_be_previewed_by_a_guest()
    {
        $translation = factory(Translation::class)->state('draft')->create();

        $response = $this->asGuest()->get("/admin/pages/previews/{$translation->id}");
        $response->assertStatus(302);

        $response->assertRedirect("/admin/login");
    }
}
