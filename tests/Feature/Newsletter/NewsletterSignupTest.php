<?php

namespace Tests\Feature\Newsletter;

use Tests\TestCase;

class NewsletterSignupTest extends TestCase
{
    /**
     *@test
     */
    public function can_sign_up_for_a_newsletter()
    {
        $this->withoutExceptionHandling();

        $response = $this->asGuest()->postJson("/newsletter/subscribe", [
            'email' => 'test@test.test',
            'name' => 'test name',
        ]);
        $response->assertSuccessful();

        $expected = [
            'subscribed' => true,
            'message' => 'Successfully subscribed, thanks!'
        ];

        $this->assertEquals($expected, $response->json());
    }
}
