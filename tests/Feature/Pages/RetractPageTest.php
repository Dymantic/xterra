<?php


namespace Tests\Feature\Pages;


use App\Pages\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetractPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function retract_a_public_page()
    {
        $this->withoutExceptionHandling();

        $page = factory(Page::class)->state('public')->create();

        $response = $this->asAdmin()->deleteJson("/admin/published-pages/{$page->id}");
        $response->assertSuccessful();

        $this->assertDatabaseHas('pages', [
            'id'        => $page->id,
            'is_public' => false,
        ]);
    }
}
