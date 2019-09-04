<?php


namespace Tests\Feature\Profile;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserInfoTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_name_and_email()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'name' => 'old name',
            'email' => 'old@test.test'
        ]);

        $response = $this->actingAs($user)->postJson("/admin/me", [
            'name' => 'new name',
            'email' => 'new@test.test'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'new name',
            'email' => 'new@test.test',
        ]);
    }

    /**
     *@test
     */
    public function can_update_name_without_changing_email()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'name' => 'old name',
            'email' => 'old@test.test'
        ]);

        $response = $this->actingAs($user)->postJson("/admin/me", [
            'name' => 'new name',
            'email' => 'old@test.test'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'new name',
            'email' => 'old@test.test',
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required()
    {
        $this->assertFieldIsInvalid(['name' => '']);
    }

    /**
     *@test
     */
    public function the_email_is_required()
    {
        $this->assertFieldIsInvalid(['email' => '']);
    }

    /**
     *@test
     */
    public function the_email_can_only_be_an_email_address()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-valid-email']);
    }

    private function assertFieldIsInvalid($field)
    {
        $user = factory(User::class)->create();
        $valid = [
            'name' => 'test name',
            'email' => 'test@test.test'
        ];

        $response = $this->actingAs($user)->postJson("/admin/me", array_merge($valid, $field));
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}