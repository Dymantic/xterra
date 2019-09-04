<?php

namespace Tests\Feature\Profile;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_authenticated_user_info()
    {
        $this->withoutExceptionHandling();
        $user_data = [
            'name' => 'test name',
            'email' => 'test@test.test',
        ];
        $user = factory(User::class)->create($user_data);

        $response = $this->actingAs($user)->getJson("/admin/me");
        $response->assertStatus(200);

        $this->assertEquals($user_data, $response->decodeResponseJson());
    }
}