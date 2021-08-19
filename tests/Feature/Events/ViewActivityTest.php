<?php

namespace Tests\Feature\Events;

use App\Occasions\Activity;
use App\Occasions\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_activity_for_a_non_public_event_should_not_be_viewable()
    {
        $this->refreshApplicationWithLocale('en');

        $event = factory(Event::class)->state('private')->create();
        $activity = factory(Activity::class)->create(['event_id' => $event->id, 'slug' => '123']);

        $response = $this->asGuest()->get("/en/races/{$activity->slug}");
        $response->assertNotFound();
    }
}
