<?php


namespace Tests\Feature\Auth;


use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function sends_email_with_link_to_reset_password()
    {
        Notification::fake();
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(['email' => 'test@test.test']);

        $response = $this->post(route("password.email"), ['email' => 'test@test.test']);
        $response->assertStatus(302);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     *@test
     */
    public function does_not_send_email_to_unknown_email()
    {
        Notification::fake();
        $this->withoutExceptionHandling();

        $response = $this->post(route("password.email"), ['email' => 'not-real@test.test']);
        $response->assertStatus(302);

        Notification::assertNothingSent();
    }

}