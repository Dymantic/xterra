<?php


namespace Tests\Feature\Blog;


use App\Blog\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_the_categories()
    {
        $this->withoutExceptionHandling();

        $categories = factory(Category::class, 4)->create();

        $response = $this->asAdmin()->getJson("/admin/categories");
        $response->assertStatus(200);

        $categries_with_count = Category::withCount('articles')->get()->map->toArray()->all();

        $this->assertCount(4, $response->json());
        $this->assertEquals($categries_with_count, $response->json());
    }
}
