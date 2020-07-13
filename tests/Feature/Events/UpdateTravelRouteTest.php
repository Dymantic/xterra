<?php


namespace Tests\Feature\Events;


use App\Occasions\TravelRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateTravelRouteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_travel_route()
    {
        $this->withoutExceptionHandling();

        $route = factory(TravelRoute::class)->create();

        $response = $this->asAdmin()->postJson("/admin/travel-routes/{$route->id}", [
            'name'        => ['en' => "new name", 'zh' => "zh new name"],
            'description' => ['en' => "new description", 'zh' => "zh new description"],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('travel_routes', [
            'id'          => $route->id,
            'name'        => json_encode(['en' => "new name", 'zh' => "zh new name"]),
            'description' => json_encode(['en' => "new description", 'zh' => "zh new description"]),
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['name' => null]);
    }

    /**
     *@test
     */
    public function the_description_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['name' => ['en' => null, 'zh' => ""]]);
    }

    private function assertFieldIsInvalid($field)
    {
        $route = factory(TravelRoute::class)->create();

        $valid = [
            'name'        => ['en' => "new name", 'zh' => "zh new name"],
            'description' => ['en' => "new description", 'zh' => "zh new description"],
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/travel-routes/{$route->id}", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
