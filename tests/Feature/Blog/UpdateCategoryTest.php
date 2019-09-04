<?php


namespace Tests\Feature\Blog;


use App\Blog\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_a_category()
    {
        $this->withoutExceptionHandling();

        $category = factory(Category::class)->create([
            'title' => ['en' => 'test title', 'zh' => 'zh test title']
        ]);

        $response = $this->asAdmin()->postJson("/admin/categories/{$category->id}", [
            'title' => ['en' => 'new title', 'zh' => 'zh new title']
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'title' => json_encode(['en' => 'new title', 'zh' => 'zh new title']),
        ]);
    }

    /**
     *@test
     */
    public function the_title_is_required()
    {
        $category = factory(Category::class)->create();

        $response = $this->asAdmin()->postJson("/admin/categories/{$category->id}", [
            'title' => ''
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    /**
     *@test
     */
    public function the_title_must_be_in_array_form()
    {
        $category = factory(Category::class)->create();

        $response = $this->asAdmin()->postJson("/admin/categories/{$category->id}", [
            'title' => 'just-a-string'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    /**
     *@test
     */
    public function the_english_title_must_be_present()
    {
        $category = factory(Category::class)->create();

        $response = $this->asAdmin()->postJson("/admin/categories/{$category->id}", [
            'title' => ['zh' => 'test zh title']
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title.en');
    }
}