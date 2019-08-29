<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function user_logs_in()
    {
        $this->withoutExceptionHandling();
        $password_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // = password
        $user = factory(User::class)->create([
            'email' => 'test@test.test',
            'password' => $password_hash,
        ]);

        $response = $this->asGuest()->post("/admin/login", [
            'email' => 'test@test.test',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect("/admin/pages/dashboard");

        $this->assertAuthenticatedAs($user);
    }

    /**
     *@test
     */
    public function cannot_use_fake_credentials()
    {
        $response = $this->from("/admin/login")->asGuest()->post("/admin/login", [
            'email' => 'does-not@test.test',
            'password' => 'fake-password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect("/admin/login");

        $this->assertGuest();
    }
}