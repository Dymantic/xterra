<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterSignupController extends Controller
{
    public function store()
    {
        sleep(2);
        return [
            'subscribed' => true,
            'message' => 'Successfully subscribed, thanks!'
        ];
    }
}
