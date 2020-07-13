<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateEventTravelRouteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function add_a_travel_route_to_an_event()
    {
        $this->withoutExceptionHandling();

        $event = factory(Event::class)->create();

        $response = $this->asAdmin()->postJson("/admin/events/{$event->id}/travel-routes", [
            'name'        => ['en' => "test name", 'zh' => "zh test name"],
            'description' => ['en' => "test description", 'zh' => "zh test description"],
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('travel_routes', [
            'event_id'    => $event->id,
            'name'        => json_encode(['en' => "test name", 'zh' => "zh test name"]),
            'description' => json_encode(['en' => "test description", 'zh' => "zh test description"]),
        ]);
    }

    /**
     * @test
     */
    public function the_name_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['name' => ['en' => "", 'zh' => ""]]);
    }

    /**
     *@test
     */
    public function the_description_is_required_in_at_least_one_language()
    {
        $this->assertFieldIsInvalid(['description' => ['en' => "", 'zh' => ""]]);
    }

    private function assertFieldIsInvalid($field)
    {
        $event = factory(Event::class)->create();

        $valid = [
            'name'        => ['en' => "test name", 'zh' => "zh test name"],
            'description' => ['en' => "test description", 'zh' => "zh test description"],
        ];

        $response = $this
            ->asAdmin()
            ->postJson("/admin/events/{$event->id}/travel-routes", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
