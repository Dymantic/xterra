<?php

namespace Tests\Feature\Shop;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreatePromotionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_the_main_promotion_for_the_store()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/promotions", [
            'title'       => ['en' => 'test title', 'zh' => 'zh test title'],
            'writeup'     => ['en' => 'test writeup', 'zh' => 'zh test writeup'],
            'button_text' => ['en' => 'test button text', 'zh' => 'zh test button text'],
            'link'        => 'https://test.test',
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('promotions', [
            'title'       => json_encode(['en' => 'test title', 'zh' => 'zh test title']),
            'writeup'     => json_encode(['en' => 'test writeup', 'zh' => 'zh test writeup']),
            'button_text' => json_encode(['en' => 'test button text', 'zh' => 'zh test button text']),
            'link'        => 'https://test.test',
        ]);
    }

    /**
     * @test
     */
    public function some_empty_fields_are_allowed()
    {
        $response = $this->asAdmin()->postJson("/admin/promotions", [
            'title'   => ['en' => 'test title', 'zh' => null],
            'writeup' => ['en' => null, 'zh' => null],
            'button_text' => ['en' => null, 'zh' => null],
            'link'    => null,
        ]);

        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function the_title_requires_at_least_one_translation()
    {
        $this->assertFieldIsInvalid(['title' => []]);
    }

    /**
     * @test
     */
    public function the_writeup_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['writeup' => 'not-a-translation-array']);
    }

    /**
     *@test
     */
    public function the_button_text_must_be_a_translation()
    {
        $this->assertFieldIsInvalid(['button_text' => 'not-a-translation-array']);
    }

    /**
     * @test
     */
    public function the_link_must_be_a_url()
    {
        $this->assertFieldIsInvalid(['link' => 'not-a-url']);
    }

    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'title'   => ['en' => 'test title', 'zh' => 'zh test title'],
            'writeup' => ['en' => 'test writeup', 'zh' => 'zh test writeup'],
            'link'    => 'https://test.test',
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/promotions", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
