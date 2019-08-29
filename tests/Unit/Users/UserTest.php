<?php

namespace Tests\Unit\Users;

use App\User;
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
}