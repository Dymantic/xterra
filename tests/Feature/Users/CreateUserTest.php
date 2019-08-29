<?php

namespace Tests\Feature\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_user()
    {
        $this->withoutExceptionHandling();

        $response = $this->asAdmin()->postJson("/admin/users", [
            'name'                  => 'Test name',
            'email'                 => 'test@test.test',
            'password'              => 'test_password',
            'password_confirmation' => 'test_password'
        ]);
        $response->assertStatus(201);

        $created_user = User::where('email', 'test@test.test')->first();

        $this->assertEquals('Test name', $created_user->name);
        $this->assertEquals('test@test.test', $created_user->email);

        $this->assertTrue(Hash::check('test_password', $created_user->password));
    }

    /**
     * @test
     */
    public function user_cannot_be_created_by_a_guest()
    {
        $response = $this->asGuest()->postJson("/admin/users", [
            'name'                  => 'Test name',
            'email'                 => 'test@test.test',
            'password'              => 'test_password',
            'password_confirmation' => 'test_password'
        ]);
        $response->assertStatus(401);

        $created_user = User::where('email', 'test@test.test')->first();
        $this->assertNull($created_user);
    }

    /**
     * @test
     */
    public function the_name_is_required()
    {
        $this->assertFieldIsInvalid(['name' => '']);
    }

    /**
     * @test
     */
    public function the_email_is_required()
    {
        $this->assertFieldIsInvalid(['email' => '']);
    }

    /**
     * @test
     */
    public function the_email_must_be_valid_format()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-valid-email-address']);
    }

    /**
     * @test
     */
    public function the_email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'used@test.test']);

        $this->assertFieldIsInvalid(['email' => 'used@test.test']);
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
    public function the_password_must_be_eight_or_more_characters()
    {
        $this->assertFieldIsInvalid([
            'password'              => 'short',
            'password_confirmation' => 'short'
        ]);
    }

    /**
     * @test
     */
    public function the_password_must_be_confirmed()
    {
        $this->assertFieldIsInvalid([
            'password'              => 'password',
            'password_confirmation' => 'different'
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        $valid = [
            'name'                  => 'Test name',
            'email'                 => 'test@test.test',
            'password'              => 'test_password',
            'password_confirmation' => 'test_password'
        ];

        $response = $this->asAdmin()->postJson("/admin/users", array_merge($valid, $field));
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}