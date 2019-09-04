<?php

namespace Tests\Feature\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_all_users()
    {
        $this->withoutExceptionHandling();

        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userC = factory(User::class)->create();
        $userD = factory(User::class)->create();

        $response = $this->actingAs($userA)->getJson("/admin/users");
        $response->assertStatus(200);

        $fetched_users = collect($response->decodeResponseJson());

        $this->assertCount(4, $fetched_users);

        $this->assertContains($userA->toArray(), $fetched_users);
        $this->assertContains($userB->toArray(), $fetched_users);
        $this->assertContains($userC->toArray(), $fetched_users);
        $this->assertContains($userD->toArray(), $fetched_users);
    }
}