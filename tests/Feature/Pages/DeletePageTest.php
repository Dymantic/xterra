<?php


namespace Tests\Feature\Pages;


use App\Pages\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_page()
    {
        $this->withoutExceptionHandling();

        $page = factory(Page::class)->state('public')->create();

        $response = $this->asAdmin()->deleteJson("/admin/pages/{$page->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('pages', [
            'id'        => $page->id,
        ]);
    }
}
