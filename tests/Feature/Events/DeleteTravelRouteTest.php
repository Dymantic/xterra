<?php


namespace Tests\Feature\Events;


use App\Occasions\TravelRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTravelRouteTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_travel_route()
    {
        $this->withoutExceptionHandling();

        $route = factory(TravelRoute::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/travel-routes/{$route->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('travel_routes', ['id' => $route->id]);
    }
}
