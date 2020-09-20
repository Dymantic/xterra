<?php


namespace Tests\Feature\Media;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateGenericContentCardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_generic_content_card()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/content-cards", [
            'category' => ['en' => 'test category', 'zh' => 'zh test category'],
            'title'    => ['en' => 'test title', 'zh' => 'zh test title'],
            'link'     => 'https://test.test',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('content_cards', [
            'category' => json_encode(['en' => 'test category', 'zh' => 'zh test category']),
            'title'    => json_encode(['en' => 'test title', 'zh' => 'zh test title']),
            'link'     => 'https://test.test',
        ]);
    }

    /**
     *@test
     */
    public function some_empty_fields_and_states_allowed()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/content-cards", [
            'category' => ['en' => '', 'zh' => ''],
            'title'    => ['en' => 'test title', 'zh' => ''],
            'link'     => null,
        ]);
        $response->assertSuccessful();
    }

    /**
     *@test
     */
    public function the_title_is_required_in_at_least_one_translation()
    {
        $this->assertFieldIsInvalid(['title' => ['en' => null, 'zh' => '']]);
    }

    /**
     *@test
     */
    public function the_category_must_be_a_translation_array()
    {
        $this->assertFieldIsInvalid(['category' => 'not-even-an-array']);
    }



    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'category' => ['en' => 'test category', 'zh' => 'zh test category'],
            'title'    => ['en' => 'test title', 'zh' => 'zh test title'],
            'link'     => 'https://test.test',
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/content-cards", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
