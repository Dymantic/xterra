<?php

namespace Tests\Feature\Blog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_a_category()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/categories", [
            'title' => [
                'en' => 'test category',
                'zh' => 'zh test category'
            ],
            'description' => [
                'en' => 'test description',
                'zh' => 'zh test description'
            ]
        ]);
        $response->assertStatus(201);

        $this->assertDatabaseHas('categories', [
            'title' => json_encode([
                'en' => 'test category',
                'zh' => 'zh test category'
            ]),
            'description' => json_encode([
                'en' => 'test description',
                'zh' => 'zh test description'
            ]),
            'slug' => 'test-category'
        ]);
    }

    /**
     *@test
     */
    public function the_english_title_is_required()
    {
        $response = $this->asAdmin()->postJson("/admin/categories", [
            'title' => [
                'zh' => 'zh test category'
            ]
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title.en');
    }

    /**
     *@test
     */
    public function the_english_title_cannot_be_empty()
    {
        $response = $this->asAdmin()->postJson("/admin/categories", [
            'title' => [
                'en' => '',
                'zh' => 'zh test category'
            ]
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title.en');
    }

    /**
     *@test
     */
    public function the_chinese_is_not_initially_required()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/categories", [
            'title' => [
                'en' => 'test category',
            ]
        ]);
        $response->assertStatus(201);

        $this->assertDatabaseHas('categories', [
            'title' => json_encode([
                'en' => 'test category',
                'zh' => ''
            ]),
            'slug' => 'test-category'
        ]);
    }
}