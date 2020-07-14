<?php


namespace Tests\Unit\Events;


use App\Occasions\Accommodation;
use App\Occasions\AccommodationInfo;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventAccommodationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_add_accommodation_to_an_event()
    {
        $event = factory(Event::class)->create();

        $accommodation_info = new AccommodationInfo([
            'name'        => ['en' => "test name", 'zh' => "zh test name"],
            'description' => ['en' => "test description", 'zh' => "zh test description"],
            'link'        => 'https://test.test',
            'phone'       => 'test phone',
            'email'       => 'test@test.test',
        ]);

        $accommodation = $event->addAccommodation($accommodation_info);

        $this->assertInstanceOf(Accommodation::class, $accommodation);
        $this->assertEquals('test@test.test', $accommodation->email);
        $this->assertEquals('test phone', $accommodation->phone);
        $this->assertEquals('https://test.test', $accommodation->link);
        $this->assertEquals(['en' => "test name", 'zh' => "zh test name"], $accommodation->name);
        $this->assertEquals(['en' => "test description", 'zh' => "zh test description"], $accommodation->description);
    }
}
