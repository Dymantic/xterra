<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RetiredUserCannotLoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_retired_user_cannot_log_in()
    {
        $user = factory(User::class)->create([
            'email' => 'test@test.test',
            'password' => Hash::make('password'),
        ]);

        $user->retire();

        $response = $this->from("/admin/login")->asGuest()->post("/admin/login", [
            'email' => 'test@test.test',
            'password' => 'password',
        ]);
        $this->assertFalse(auth()->check());
        $response->assertRedirect("/admin/login");
    }
}