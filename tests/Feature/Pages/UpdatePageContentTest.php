<?php


namespace Tests\Feature\Pages;


use App\Pages\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdatePageContentTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_page_content_for_a_given_lang()
    {
        $this->withoutExceptionHandling();

        $page = factory(Page::class)->create();

        $response = $this->asAdmin()->postJson("/admin/pages/{$page->id}/content", [
            'content' => 'test content',
            'lang' => 'en',
        ]);
        $response->assertSuccessful();

        $this->assertSame('test content', $page->fresh()->content->in('en'));
    }

    /**
     *@test
     */
    public function the_content_is_required()
    {
        $this->assertFieldIsInvalid(['content' => null]);
    }

    /**
     *@test
     */
    public function the_lang_is_required()
    {
        $this->assertFieldIsInvalid(['lang' => null]);
    }

    /**
     *@test
     */
    public function lang_must_be_either_en_or_zh()
    {
        $this->assertFieldIsInvalid(['lang' => 'fr']);
    }

    private function assertFieldIsInvalid($field)
    {
        $page = factory(Page::class)->create();

        $valid = [
            'content' => 'test content',
            'lang' => 'en',
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/pages/{$page->id}/content", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
