<?php


namespace Tests\Feature\People;


use App\People\Ambassador;
use App\People\Coach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewPeopleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function unpublished_people_are_not_included_on_friends_page()
    {
        $this->withoutExceptionHandling();
        $this->refreshApplicationWithLocale('en');

        $private_coach = factory(Coach::class)->state('private')->create();
        $public_coach = factory(Coach::class)->state('public')->create();
        $public_ambassador = factory(Ambassador::class)->state('public')->create();

        $response = $this->asGuest()->followingRedirects()->get('/en/friends');
        $friends = $response->original->getData()['people'];

        $this->assertCount(2, $friends);

        $this->assertTrue(collect($friends)->contains(
            fn($f) => $f['name'] === $public_coach->name->in('en'))
        );
        $this->assertTrue(collect($friends)->contains(
            fn($f) => $f['name'] === $public_ambassador->name->in('en'))
        );
        $this->assertFalse(collect($friends)->contains(
            fn($f) => $f['name'] === $private_coach->name->in('en'))
        );

    }

    /**
     * @test
     */
    public function cannot_view_unpublished_coach_page()
    {
        $this->withoutExceptionHandling();
        $this->refreshApplicationWithLocale('en');

        $private_coach = factory(Coach::class)->state('private')->create();

        $response = $this
            ->asGuest()
            ->followingRedirects()
            ->get("/en/coaches/{$private_coach->slug}")
            ->assertNotFound();
    }

    /**
     *@test
     */
    public function cannot_view_unpublished_ambassador()
    {
        $this->withoutExceptionHandling();
        $this->refreshApplicationWithLocale('en');

        $private_ambassador = factory(Ambassador::class)->state('private')->create();

        $this
            ->asGuest()
            ->followingRedirects()
            ->get("/en/ambassadors/{$private_ambassador->slug}")
            ->assertNotFound();
    }
}
