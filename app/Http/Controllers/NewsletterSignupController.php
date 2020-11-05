<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Newsletter\NewsletterFacade;

class NewsletterSignupController extends Controller
{
    public function store()
    {
        NewsletterFacade::subscribe(request('email'), ['FNAME' => request('name', 'anonymous')]);
        return [
            'subscribed' => !NewsletterFacade::getLastError(),
            'message' => 'Successfully subscribed, thanks!'
        ];
    }
}
