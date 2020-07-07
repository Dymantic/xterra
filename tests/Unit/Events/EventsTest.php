<?php

namespace Tests\Unit\Events;

use App\DatePresenter;
use App\Occasions\Event;
use App\Occasions\GeneralEventInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_new_event_with_name()
    {
        $event = Event::createWithName([
            'en' => 'test name',
            'zh' => 'zh test name'
        ]);

        $this->assertEquals('test name', $event->name['en']);
        $this->assertEquals('zh test name', $event->name['zh']);
        $this->assertTrue(Str::isUuid($event->slug));
    }

    /**
     *@test
     */
    public function update_the_general_info_of_an_event()
    {
        $event = factory(Event::class)->state('empty')->create();
        $info = new GeneralEventInfo([
            'name' => ['en' => 'new test name', 'zh' => 'new zh test name'],
            'location' => ['en' => 'test location', 'zh' => 'zh test location'],
            'venue_name' => ['en' => 'test venue_name', 'zh' => 'zh test venue_name'],
            'venue_address' => ['en' => 'test venue_address', 'zh' => 'zh test venue_address'],
            'venue_maplink' => 'https://test.test/map',
            'start' => Carbon::today()->addMonth()->format(DatePresenter::STANDARD),
            'end' => Carbon::today()->addMonth()->addDay()->format(DatePresenter::STANDARD),
            'registration_link' => 'https://test.test/registration',
        ]);

        $event->updateGeneralInfo($info);
        $event = $event->fresh();

        $this->assertEquals('new test name', $event->name['en']);
        $this->assertEquals('new zh test name', $event->name['zh']);
        $this->assertEquals('test location', $event->location['en']);
        $this->assertEquals('zh test location', $event->location['zh']);
        $this->assertEquals('test venue_name', $event->venue_name['en']);
        $this->assertEquals('zh test venue_name', $event->venue_name['zh']);
        $this->assertEquals('test venue_address', $event->venue_address['en']);
        $this->assertEquals('zh test venue_address', $event->venue_address['zh']);
        $this->assertEquals('https://test.test/map', $event->venue_maplink);
        $this->assertTrue(Carbon::today()->addMonth()->startOfDay()->eq($event->start));
        $this->assertTrue(Carbon::today()->addMonth()->addDay()->endOfDay()->setMicro(0)->equalTo($event->end));
        $this->assertEquals('https://test.test/registration', $event->registration_link);

    }
}
