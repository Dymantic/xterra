<?php


namespace Tests\Unit\Events;


use App\Occasions\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RacePrizesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_the_prizes_for_a_race()
    {
        $race = factory(Activity::class)->state('race')->create();

        $race->setPrizes("en prize table", "en");

        $this->assertSame("en prize table", $race->prizes->in("en"));
        $this->assertSame("", $race->prizes->in("zh"));

        $race->setPrizes("zh prize table", "zh");

        $this->assertSame("en prize table", $race->prizes->in("en"));
        $this->assertSame("zh prize table", $race->prizes->in("zh"));
    }
}
