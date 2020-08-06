<?php


namespace Tests\Feature\Pages;


use App\Pages\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function publish_a_page()
    {
        $this->withoutExceptionHandling();

        $page = factory(Page::class)->state('private')->create();

        $response = $this->asAdmin()->postJson("/admin/published-pages", [
            'page_id' => $page->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'is_public' => true,
        ]);
    }
}
