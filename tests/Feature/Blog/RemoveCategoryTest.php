<?php


namespace Tests\Feature\Blog;


use App\Blog\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function remove_a_category()
    {
        $this->withoutExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/categories/{$category->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}