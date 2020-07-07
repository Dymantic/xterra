<?php


namespace Tests\Unit\Events;


use App\Occasions\Activity;
use App\Occasions\ActivityInfo;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRacesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_add_race_to_an_event()
    {
        $event = factory(Event::class)->create();

        $raceInfo = ActivityInfo::forRace([
            'name' => ['en' => 'test name', 'zh' => 'zh test name'],
            'distance' => ['en' => 'test distance', 'zh' => 'zh test distance'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'category' => Activity::RUN,
        ]);

        $race = $event->addRace($raceInfo);

        $this->assertInstanceOf(Activity::class, $race);
        $this->assertEquals(['en' => 'test name', 'zh' => 'zh test name'], $race->name);
        $this->assertEquals(['en' => 'test distance', 'zh' => 'zh test distance'], $race->distance);
        $this->assertEquals(['en' => 'test description', 'zh' => 'zh test description'], $race->description);
        $this->assertEquals(Activity::RUN, $race->category);

    }
}
