<?php


namespace Tests\Feature\Pages;


use App\Pages\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdatePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_page()
    {
        $this->withoutExceptionHandling();

        $page = factory(Page::class)->create();

        $response = $this->asAdmin()->postJson("/admin/pages/{$page->id}", [
            'title'       => ['en' => 'new title', 'zh' => 'zh new title'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
            'blurb'       => ['en' => 'new blurb', 'zh' => 'zh new blurb'],
            'menu_name'   => ['en' => 'new menu name', 'zh' => 'zh new menu name'],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('pages', [
            'title'       => json_encode(['en' => 'new title', 'zh' => 'zh new title']),
            'description' => json_encode(['en' => 'new description', 'zh' => 'zh new description']),
            'blurb'       => json_encode(['en' => 'new blurb', 'zh' => 'zh new blurb']),
            'menu_name'   => json_encode(['en' => 'new menu name', 'zh' => 'zh new menu name']),
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required_in_english_at_least()
    {
        $this->assertFieldIsInvalid(['title' => null]);
        $this->assertFieldIsInvalid(['title' => 'not-translation']);
        $this->assertFieldIsInvalid(['title' => []]);
        $this->assertFieldIsInvalid(['title' => ['en' => null]]);
        $this->assertFieldIsInvalid(['title' => ['en' => null, 'zh' => 'zh test title']]);
    }

    /**
     *@test
     */
    public function the_description_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['description' => 'not-a-translation']);
    }

    /**
     *@test
     */
    public function the_blurb_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['blurb' => ['not-a-translation']]);
    }

    /**
     *@test
     */
    public function the_content_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['content' => ['not-a-translation']]);
    }

    /**
     *@test
     */
    public function the_menu_name_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['menu_name' => ['not-a-translation']]);
    }

    private function assertFieldIsInvalid($field)
    {
        $page = factory(Page::class)->create();

        $valid = [
            'title'       => ['en' => 'new title', 'zh' => 'zh new title'],
            'description' => ['en' => 'new description', 'zh' => 'zh new description'],
            'blurb'       => ['en' => 'new blurb', 'zh' => 'zh new blurb'],
            'content'     => ['en' => 'new content', 'zh' => 'zh new content'],
            'menu_name'   => ['en' => 'new menu name', 'zh' => 'zh new menu name'],
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/pages/{$page->id}", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
