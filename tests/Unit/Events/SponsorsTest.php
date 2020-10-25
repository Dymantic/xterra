<?php


namespace Tests\Unit\Events;


use App\Occasions\Event;
use App\Occasions\Sponsor;
use App\Occasions\SponsorInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SponsorsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_set_the_order_for_sponsors()
    {
        $sponsorA = factory(Sponsor::class)->create();
        $sponsorB = factory(Sponsor::class)->create();
        $sponsorC = factory(Sponsor::class)->create();
        $sponsorD = factory(Sponsor::class)->create();

        Sponsor::setOrder([$sponsorB->id, $sponsorA->id, $sponsorC->id, $sponsorD->id]);

        $this->assertSame(1, $sponsorB->fresh()->position);
        $this->assertSame(2, $sponsorA->fresh()->position);
        $this->assertSame(3, $sponsorC->fresh()->position);
        $this->assertSame(4, $sponsorD->fresh()->position);
    }

    /**
     *@test
     */
    public function adding_a_new_sponsor_to_event_gives_it_a_position()
    {
        $event = factory(Event::class)->create();
        factory(Sponsor::class)->create(['event_id' => $event, 'position' => 1]);
        factory(Sponsor::class)->create(['event_id' => $event, 'position' => 2]);
        factory(Sponsor::class)->create(['event_id' => $event, 'position' => 3]);

        $sponsor_info = new SponsorInfo([
            'name' => ['en' => 'test name', 'zh' => 'zh test name'],
            'description' => ['en' => 'test description', 'zh' => 'zh test description'],
            'link' => 'https://test.test'
        ]);

        $sponsor = $event->addSponsor($sponsor_info);

        $this->assertSame(4, $sponsor->position);

    }
}
