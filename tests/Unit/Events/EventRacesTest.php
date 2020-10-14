<?php


namespace Tests\Unit\Events;


use App\DatePresenter;
use App\Occasions\Activity;
use App\Occasions\ActivityInfo;
use App\Occasions\Event;
use App\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'name'              => ['en' => 'test name', 'zh' => 'zh test name'],
            'distance'          => ['en' => 'test distance', 'zh' => 'zh test distance'],
            'intro'             => ['en' => 'test intro', 'zh' => 'zh test intro'],
            'category'          => Activity::RUN,
            'date'              => Carbon::today()->addMonth()->format(DatePresenter::STANDARD),
            'venue_name'        => ['en' => 'test venue_name', 'zh' => 'zh test venue_name'],
            'venue_address'     => ['en' => 'test venue_address', 'zh' => 'zh test venue_address'],
            'map_link'          => 'https://maps.test',
            'registration_link' => 'https://registration.test',
        ]);

        $race = $event->addRace($raceInfo);

        $this->assertInstanceOf(Activity::class, $race);
        $this->assertEquals(['en' => 'test name', 'zh' => 'zh test name'], $race->name);
        $this->assertEquals(['en' => 'test distance', 'zh' => 'zh test distance'], $race->distance);
        $this->assertEquals(['en' => "test intro", 'zh' => "zh test intro"], $race->intro->toArray());
        $this->assertEquals(Activity::RUN, $race->category);
        $this->assertTrue($race->is_race);

        $this->assertSame(['en' => 'test venue_name', 'zh' => 'zh test venue_name'], $race->venue_name);
        $this->assertSame(['en' => 'test venue_address', 'zh' => 'zh test venue_address'], $race->venue_address);
        $this->assertSame('https://maps.test', $race->map_link);
        $this->assertSame('https://registration.test', $race->registration_link);
        $this->assertTrue(Carbon::today()->addMonth()->isSameDay($race->date));

    }

    /**
     * @test
     */
    public function can_add_an_activity_to_an_event()
    {
        $event = factory(Event::class)->create();

        $activity_info = ActivityInfo::forActivity([
            'name'     => ['en' => 'test name', 'zh' => 'zh test name'],
            'distance' => ['en' => 'test distance', 'zh' => 'zh test distance'],
            'category' => Activity::RUN,
        ]);

        $activity = $event->addActivity($activity_info);

        $this->assertInstanceOf(Activity::class, $activity);
        $this->assertEquals(['en' => 'test name', 'zh' => 'zh test name'], $activity->name);
        $this->assertEquals(['en' => 'test distance', 'zh' => 'zh test distance'], $activity->distance);
        $this->assertEquals(Activity::RUN, $activity->category);
        $this->assertFalse($activity->is_race);
    }

    /**
     * @test
     */
    public function can_set_schedule_notes_for_activity()
    {
        $activity = factory(Activity::class)->create();

        $activity->setScheduleNotes(['en' => "test notes", 'zh' => "zh test notes"]);

        $this->assertEquals(
            ['en' => "test notes", 'zh' => "zh test notes"], $activity->fresh()->schedule_notes
        );
    }

    /**
     * @test
     */
    public function can_set_the_prize_notes_for_a_race()
    {
        $activity = factory(Activity::class)->create();

        $activity->setPrizeNotes(['en' => "test notes", 'zh' => "zh test notes"]);

        $this->assertEquals(
            ['en' => "test notes", 'zh' => "zh test notes"], $activity->fresh()->prize_notes
        );
    }

    /**
     * @test
     */
    public function can_set_the_fees_notes_for_a_race()
    {
        $activity = factory(Activity::class)->create();

        $activity->setFeesNotes(['en' => "test notes", 'zh' => "zh test notes"]);

        $this->assertEquals(
            ['en' => "test notes", 'zh' => "zh test notes"], $activity->fresh()->fees_notes
        );
    }

    /**
     * @test
     */
    public function can_set_the_rules_and_info_doc()
    {
        Storage::fake('admin_uploads');
        $race = factory(Activity::class)->create();
        $doc = UploadedFile::fake()->create('test_doc.pdf');

        $race->setRulesAndInfoDoc($doc);

        Storage::disk('admin_uploads')->assertExists($doc->hashName('race_rules'));

        $this->assertEquals($doc->hashName('race_rules'), $race->fresh()->race_rules_doc);
        $this->assertEquals('admin_uploads', $race->fresh()->race_rules_disk);
    }

    /**
     * @test
     */
    public function can_clear_the_rules_doc()
    {
        Storage::fake('admin_uploads');
        $race = factory(Activity::class)->create();
        $doc = UploadedFile::fake()->create('test_doc.pdf');

        $race->setRulesAndInfoDoc($doc);

        $race->clearRulesAndInfoDoc();

        Storage::disk('admin_uploads')->assertMissing($doc->hashName('race_rules'));
        $this->assertNull($race->fresh()->race_rules_doc);
        $this->assertNull($race->fresh()->race_rules_disk);
    }

    /**
     * @test
     */
    public function can_set_the_athlete_guide()
    {
        Storage::fake('admin_uploads');
        $race = factory(Activity::class)->create();
        $doc = UploadedFile::fake()->create('test_doc.pdf');

        $race->setAthleteGuide($doc);

        Storage::disk('admin_uploads')->assertExists($doc->hashName('athlete_guides'));

        $this->assertEquals($doc->hashName('athlete_guides'), $race->fresh()->athlete_guide);
        $this->assertEquals('admin_uploads', $race->fresh()->athlete_guide_disk);
    }

    /**
     * @test
     */
    public function can_clear_the_athlete_guide()
    {
        Storage::fake('admin_uploads');
        $race = factory(Activity::class)->create();
        $doc = UploadedFile::fake()->create('test_doc.pdf');

        $race->setAthleteGuide($doc);

        $race->clearAthleteGuide();

        Storage::disk('admin_uploads')->assertMissing($doc->hashName('athlete_guides'));
        $this->assertNull($race->fresh()->athlete_guide);
        $this->assertNull($race->fresh()->athlete_guide_disk);
    }

    /**
     * @test
     */
    public function set_the_zh_race_rules_disk()
    {
        Storage::fake('admin_uploads');
        $race = factory(Activity::class)->create();
        $doc = UploadedFile::fake()->create('test_doc.pdf');

        $race->setChineseRulesAndInfoDoc($doc);

        Storage::disk('admin_uploads')->assertExists($doc->hashName('race_rules'));

        $this->assertEquals($doc->hashName('race_rules'), $race->fresh()->zh_race_rules_doc);
        $this->assertEquals('admin_uploads', $race->fresh()->zh_race_rules_disk);
    }

    /**
     * @test
     */
    public function clear_the_zh_race_rules_doc()
    {
        Storage::fake('admin_uploads');
        $race = factory(Activity::class)->create();
        $doc = UploadedFile::fake()->create('test_doc.pdf');

        $race->setChineseRulesAndInfoDoc($doc);

        $race->clearChineseRulesAndInfoDoc();

        Storage::disk('admin_uploads')->assertMissing($doc->hashName('race_rules'));
        $this->assertNull($race->fresh()->race_rules_doc);
        $this->assertNull($race->fresh()->race_rules_disk);
    }

    /**
     * @test
     */
    public function can_set_the_chinese_athletes_guide()
    {
        Storage::fake('admin_uploads');
        $race = factory(Activity::class)->create();
        $doc = UploadedFile::fake()->create('test_doc.pdf');

        $race->setChineseAthleteGuide($doc);

        Storage::disk('admin_uploads')->assertExists($doc->hashName('athlete_guides'));

        $this->assertEquals($doc->hashName('athlete_guides'), $race->fresh()->zh_athlete_guide);
        $this->assertEquals('admin_uploads', $race->fresh()->zh_athlete_guide_disk);
    }

    /**
     * @test
     */
    public function can_clear_the_chinese_athlete_guide()
    {
        Storage::fake('admin_uploads');
        $race = factory(Activity::class)->create();
        $doc = UploadedFile::fake()->create('test_doc.pdf');

        $race->setChineseAthleteGuide($doc);

        $race->clearChineseAthleteGuide();

        Storage::disk('admin_uploads')->assertMissing($doc->hashName('athlete_guides'));
        $this->assertNull($race->fresh()->zh_athlete_guide);
        $this->assertNull($race->fresh()->zh_athlete_guide_disk);
    }

    /**
     * @test
     */
    public function can_update_the_rules_by_lang()
    {
        $race = factory(Activity::class)->state('race')->create();

        $race->updateRules("test rules", 'en');

        $this->assertEquals('test rules', $race->fresh()->race_rules['en']);
        $this->assertEquals('', $race->fresh()->race_rules['zh']);

        $race->updateRules("zh test rules", 'zh');

        $this->assertEquals('test rules', $race->fresh()->race_rules['en']);
        $this->assertEquals('zh test rules', $race->fresh()->race_rules['zh']);
    }

    /**
     * @test
     */
    public function can_update_the_race_info()
    {
        $race = factory(Activity::class)->state('race')->create();

        $race->updateInfo("test info", 'en');

        $this->assertEquals('test info', $race->fresh()->race_info['en']);
        $this->assertEquals('', $race->fresh()->race_info['zh']);
    }

    /**
     * @test
     */
    public function can_add_a_content_image()
    {
        Storage::fake('media');

        $race = factory(Activity::class)->state('race')->create();
        $upload = UploadedFile::fake()->image('test.png');

        $image = $race->addContentImage($upload);

        $this->assertTrue($race->getFirstMedia(Activity::CONTENT_IMAGES)->is($image));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
        $this->assertStringContainsString($upload->hashName(), $image->file_name);

        $this->assertTrue($image->fresh()->hasGeneratedConversion('web'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('web'), "/media"));
    }

    /**
     * @test
     */
    public function can_set_the_banner_image()
    {
        Storage::fake('media');

        $race = factory(Activity::class)->state('race')->create();
        $upload = UploadedFile::fake()->image('test.png');

        $image = $race->setBannerImage($upload);

        $this->assertTrue($race->getFirstMedia(Activity::BANNER_IMAGE)->is($image));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
        $this->assertStringContainsString($upload->hashName(), $image->file_name);

        $this->assertTrue($image->fresh()->hasGeneratedConversion('banner'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('banner'), "/media"));
    }

    /**
     * @test
     */
    public function can_clear_the_banner_image()
    {
        Storage::fake('media');

        $race = factory(Activity::class)->state('race')->create();
        $image = $race->setBannerImage(UploadedFile::fake()->image('test.png'));

        $race->clearBannerImage();

        $this->assertCount(0, $race->fresh()->getMedia(Activity::BANNER_IMAGE));
        Storage::disk('media')->assertMissing(Str::after($image->getUrl(''), "/media"));
    }

    /**
     * @test
     */
    public function setting_a_banner_image_clears_previous_ones()
    {
        Storage::fake('media');

        $race = factory(Activity::class)->state('race')->create();
        $old_image = $race->setBannerImage(UploadedFile::fake()->image('test.png'));

        $this->assertCount(1, $race->fresh()->getMedia(Activity::BANNER_IMAGE));

        $new_image = $race->setBannerImage(UploadedFile::fake()->image('test2.png'));
        $this->assertCount(1, $race->fresh()->getMedia(Activity::BANNER_IMAGE));

        Storage::disk('media')->assertExists(Str::after($new_image->getUrl(), "/media"));
        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), "/media"));
    }

    /**
     * @test
     */
    public function can_set_the_card_image()
    {
        Storage::fake('media');

        $race = factory(Activity::class)->state('race')->create();
        $upload = UploadedFile::fake()->image('test.png');

        $image = $race->setCardImage($upload);

        $this->assertTrue($race->getFirstMedia(Activity::CARD_IMAGE)->is($image));

        Storage::disk('media')->assertExists(Str::after($image->getUrl(), "/media"));
        $this->assertStringContainsString($upload->hashName(), $image->file_name);

        $this->assertTrue($image->fresh()->hasGeneratedConversion('card'));
        Storage::disk('media')->assertExists(Str::after($image->getUrl('card'), "/media"));
    }

    /**
     * @test
     */
    public function can_clear_the_card_image()
    {
        Storage::fake('media');

        $race = factory(Activity::class)->state('race')->create();
        $image = $race->setCardImage(UploadedFile::fake()->image('test.png'));

        $race->clearCardImage();

        $this->assertCount(0, $race->fresh()->getMedia(Activity::CARD_IMAGE));
        Storage::disk('media')->assertMissing(Str::after($image->getUrl(), "/media"));
    }

    /**
     * @test
     */
    public function setting_card_image_clears_previous_ones()
    {
        Storage::fake('media');

        $race = factory(Activity::class)->state('race')->create();
        $old_image = $race->setCardImage(UploadedFile::fake()->image('test.png'));

        $this->assertCount(1, $race->fresh()->getMedia(Activity::CARD_IMAGE));

        $new_image = $race->setCardImage(UploadedFile::fake()->image('test2.png'));
        $this->assertCount(1, $race->fresh()->getMedia(Activity::CARD_IMAGE));

        Storage::disk('media')->assertExists(Str::after($new_image->getUrl(), "/media"));
        Storage::disk('media')->assertMissing(Str::after($old_image->getUrl(), "/media"));
    }

    /**
     * @test
     */
    public function set_the_description_for_a_given_language()
    {
        $race = factory(Activity::class)->create([
            'description' => new Translation(['en' => "", 'zh' => ""],)
        ]);

        $race->updateDescription('test description', 'en');
        $this->assertEquals('test description', $race->description->in('en'));
        $this->assertEquals('', $race->description->in('zh'));

        $race->updateDescription('test zh description', 'zh');
        $this->assertEquals('test description', $race->description->in('en'));
        $this->assertEquals('test zh description', $race->description->in('zh'));
    }
}
