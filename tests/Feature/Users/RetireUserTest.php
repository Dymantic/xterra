<?php


namespace Tests\Feature\Users;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetireUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function retire_a_user()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->asAdmin()->deleteJson("/admin/users/{$user->id}");
        $response->assertStatus(200);

        $this->assertNotNull($user->fresh()->retired_on);
    }
}