<?php


namespace Tests\Feature\Profile;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function authenticated_user_can_reset_password()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(); // default password = password

        $response = $this->actingAs($user)->postJson("/admin/me/password", [
            'current_password'      => 'password',
            'password'              => 'new_password',
            'password_confirmation' => 'new_password'
        ]);
        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);

        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));
    }

    /**
     * @test
     */
    public function the_current_password_must_be_correct()
    {
        $this->assertFieldIsInvalid(['current_password' => 'not-real-password']);
    }

    /**
     * @test
     */
    public function the_password_is_required()
    {
        $this->assertFieldIsInvalid([
            'password'              => '',
            'password_confirmation' => ''
        ]);
    }

    /**
     * @test
     */
    public function the_password_must_be_at_least_8_characters_long()
    {
        $this->assertFieldIsInvalid([
            'password'              => 'short',
            'password_confirmation' => 'short'
        ]);
    }

    /**
     *@test
     */
    public function the_password_must_be_confirmed()
    {
        $this->assertFieldIsInvalid([
            'password'              => 'new_password',
            'password_confirmation' => 'totally_different'
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        $user = factory(User::class)->create(); // default password = password

        $valid = [
            'current_password'      => 'password',
            'password'              => 'new_password',
            'password_confirmation' => 'new_password'
        ];

        $response = $this
            ->actingAs($user)
            ->postJson("/admin/me/password", array_merge($valid, $field));
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}