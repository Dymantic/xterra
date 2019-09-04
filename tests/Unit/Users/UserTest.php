<?php

namespace Tests\Unit\Users;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function register_a_user()
    {
        $user_data = [
            'name' => 'Test name',
            'email' => 'test@test.test',
            'password' => 'test_password',
        ];

        $user = User::register($user_data);

        $this->assertEquals('Test name', $user->name);
        $this->assertEquals('test@test.test', $user->email);
        $this->assertTrue(Hash::check('test_password', $user->password));
    }

    /**
     *@test
     */
    public function reset_user_password()
    {
        $user = factory(User::class)->create();

        $user->resetPassword('new_password');

        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));
    }

    /**
     *@test
     */
    public function retire_a_user()
    {
        $user = factory(User::class)->create();

        $user->retire();

        $this->assertTrue($user->fresh()->retired_on->isToday());
        $this->assertTrue($user->fresh()->isRetired());
    }

    /**
     *@test
     */
    public function present_as_array()
    {
        $user = factory(User::class)->create([
            'name' => 'test name',
            'email' => 'test@test.test',
        ]);
        $user->retire();

        $expected = [
            'id' => $user->id,
            'name' => 'test name',
            'email' => 'test@test.test',
            'is_retired' => true,
            'retired_date' => Carbon::today()->format('j M, Y')
        ];

        $this->assertEquals($expected, $user->fresh()->toArray());
    }
}