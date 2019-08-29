<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function asAdmin()
    {
        $admin = factory(User::class)->create();

        return $this->actingAs($admin);
    }

    public function asGuest()
    {
        return $this->assertGuest();
    }
}
