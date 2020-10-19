<?php

namespace Tests\Unit\Events;

use App\DatePresenter;
use App\Occasions\Activity;
use App\Occasions\Event;
use App\Occasions\GeneralEventInfo;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
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

    /**
     *@test
     */
    public function can_publish_an_event()
    {
        $event = factory(Event::class)->state('private')->create();
        $this->assertFalse($event->fresh()->is_public);

        $event->publish();

        $this->assertTrue($event->fresh()->is_public);
    }

    /**
     *@test
     */
    public function can_retract_an_event()
    {
        $event = factory(Event::class)->state('public')->create();
        $this->assertTrue($event->fresh()->is_public);

        $event->retract();

        $this->assertFalse($event->fresh()->is_public);
    }

    /**
     *@test
     */
    public function can_set_a_travel_guide_on_event()
    {
        Storage::fake('admin_uploads');
        $event = factory(Event::class)->create();
        $guide = UploadedFile::fake()->create('test_doc.pdf');

        $event->setTravelGuide($guide);

        Storage::disk('admin_uploads')->assertExists($guide->hashName('travel'));

        $this->assertEquals($guide->hashName('travel'), $event->fresh()->travel_guide);
        $this->assertEquals('admin_uploads', $event->fresh()->travel_guide_disk);
    }

    /**
     *@test
     */
    public function can_clear_a_travel_guide()
    {
        Storage::fake('admin_uploads');
        $event = factory(Event::class)->create();
        $guide = UploadedFile::fake()->create('test_doc.pdf');

        $event->setTravelGuide($guide);

        $event->clearTravelGuide();

        Storage::disk('admin_uploads')->assertMissing($guide->hashName('travel'));
        $this->assertNull($event->fresh()->travel_guide);
        $this->assertNull($event->fresh()->travel_guide_disk);
    }

    /**
     *@test
     */
    public function can_get_a_travel_guide_url()
    {
        Storage::fake('admin_uploads');
        $event = factory(Event::class)->create();
        $guide = UploadedFile::fake()->create('test_doc.pdf');

        $event->setTravelGuide($guide);
        $event->refresh();

        $expected = sprintf("/%s/%s", $event->travel_guide_disk, $event->travel_guide);

        $this->assertSame($expected, $event->getTravelGuideUrl());

    }



    /**
     *@test
     */
    public function can_update_the_event_overview()
    {
        $event = factory(Event::class)->create();
        $overview = new Translation(['en' => 'test overview', 'zh' => 'zh test overview']);

        $event->setOverview($overview);

        $this->assertSame("test overview", $event->overview->in("en"));
        $this->assertSame("zh test overview", $event->overview->in("zh"));
    }

    /**
     *@test
     */
    public function can_list_activity_categories_in_event()
    {
        $event = factory(Event::class)->create();
        $cycling = factory(Activity::class)->state('race')->create([
            'category' => Activity::CYCLE,
            'event_id' => $event->id,
        ]);
        $run = factory(Activity::class)->state('race')->create([
            'category' => Activity::RUN,
            'event_id' => $event->id,
        ]);
        $seminar = factory(Activity::class)->state('activity')->create([
            'category' => Activity::SEMINAR,
            'event_id' => $event->id,
        ]);
        $lifestyle = factory(Activity::class)->state('activity')->create([
            'category' => Activity::LIFESTYLE,
            'event_id' => $event->id,
        ]);

        $expected = [Activity::CYCLE, Activity::RUN, Activity::SEMINAR, Activity::LIFESTYLE];

        $this->assertSame($expected, $event->listCategories());


    }

    /**
     *@test
     */
    public function an_event_is_cardable()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        $event = factory(Event::class)->create();
        $image = $event->setCardImage(UploadedFile::fake()->image('test.png'));

        $cardInfo = $event->cardInfo();

        $this->assertSame($event->name['en'], $cardInfo->title->in('en'));
        $this->assertSame($event->name['zh'], $cardInfo->title->in('zh'));

        $this->assertSame(Lang::get('content-cards.event', [], 'en'), $cardInfo->category->in('en'));
        $this->assertSame(Lang::get('content-cards.event', [], 'en'), $cardInfo->category->in('zh'));

        $this->assertSame("/events/{$event->slug}", $cardInfo->link);
        $this->assertStringContainsString($image->getUrl(), $cardInfo->image_path);
    }
}
