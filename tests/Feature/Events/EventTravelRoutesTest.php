<?php


namespace Tests\Feature\Events;


use App\Occasions\Event;
use App\Occasions\RouteInfo;
use App\Occasions\TravelRoute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTravelRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_add_travel_route_to_event()
    {
        $event = factory(Event::class)->create();

        $route_info = new RouteInfo([
            'name'        => ['en' => "test name", 'zh' => "zh test name"],
            'description' => ['en' => "test description", 'zh' => "zh test description"],
        ]);

        $travel_route = $event->addTravelRoute($route_info);

        $this->assertInstanceOf(TravelRoute::class, $travel_route);
        $this->assertEquals($event->id, $travel_route->event_id);
        $this->assertEquals(['en' => "test name", 'zh' => "zh test name"], $travel_route->name);
        $this->assertEquals(['en' => "test description", 'zh' => "zh test description"], $travel_route->description);
    }
}
