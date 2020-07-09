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
     * @test
     */
    public function can_add_race_to_an_event()
    {
        $event = factory(Event::class)->create();

        $raceInfo = ActivityInfo::forRace([
            'name'        => ['en' => 'test name', 'zh' => 'zh test name'],
            'distance'    => ['en' => 'test distance', 'zh' => 'zh test distance'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'category'    => Activity::RUN,
        ]);

        $race = $event->addRace($raceInfo);

        $this->assertInstanceOf(Activity::class, $race);
        $this->assertEquals(['en' => 'test name', 'zh' => 'zh test name'], $race->name);
        $this->assertEquals(['en' => 'test distance', 'zh' => 'zh test distance'], $race->distance);
        $this->assertEquals(['en' => 'test description', 'zh' => 'zh test description'], $race->description);
        $this->assertEquals(Activity::RUN, $race->category);
        $this->assertTrue($race->is_race);

    }

    /**
     * @test
     */
    public function can_add_an_activity_to_an_event()
    {
        $event = factory(Event::class)->create();

        $activity_info = ActivityInfo::forActivity([
            'name'        => ['en' => 'test name', 'zh' => 'zh test name'],
            'distance'    => ['en' => 'test distance', 'zh' => 'zh test distance'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'category'    => Activity::RUN,
        ]);

        $activity = $event->addActivity($activity_info);

        $this->assertInstanceOf(Activity::class, $activity);
        $this->assertEquals(['en' => 'test name', 'zh' => 'zh test name'], $activity->name);
        $this->assertEquals(['en' => 'test distance', 'zh' => 'zh test distance'], $activity->distance);
        $this->assertEquals(['en' => 'test description', 'zh' => 'zh test description'], $activity->description);
        $this->assertEquals(Activity::RUN, $activity->category);
        $this->assertFalse($activity->is_race);
    }
}
