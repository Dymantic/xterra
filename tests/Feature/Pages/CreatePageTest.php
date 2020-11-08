<?php

namespace Tests\Feature\Pages;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreatePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_new_page()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/pages", [
            'title'       => ['en' => 'test title', 'zh' => 'zh test title'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'blurb'       => ['en' => 'test blurb', 'zh' => 'zh test blurb'],
            'menu_name'   => ['en' => 'test menu name', 'zh' => 'zh test menu name'],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('pages', [
            'title'       => json_encode(['en' => 'test title', 'zh' => 'zh test title']),
            'description' => json_encode(['en' => 'test description', 'zh' => 'zh test description']),
            'blurb'       => json_encode(['en' => 'test blurb', 'zh' => 'zh test blurb']),
            'menu_name'   => json_encode(['en' => 'test menu name', 'zh' => 'zh test menu name']),
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
    public function the_menu_name_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['menu_name' => ['not-a-translation']]);
    }

    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'title'       => ['en' => 'test title', 'zh' => 'zh test title'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'blurb'       => ['en' => 'test blurb', 'zh' => 'zh test blurb'],
            'content'     => ['en' => 'test content', 'zh' => 'zh test content'],
            'menu_name'   => ['en' => 'test menu name', 'zh' => 'zh test menu name'],
        ];

        $response = $this->asAdmin()->postJson("/admin/pages", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
