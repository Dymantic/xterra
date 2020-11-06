<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Newsletter\NewsletterFacade;

class NewsletterSignupController extends Controller
{
    public function store()
    {
        NewsletterFacade::subscribe(request('email'), ['FNAME' => request('name', 'anonymous')]);
        $failed = NewsletterFacade::getLastError() !== false;

        return [
            'subscribed' => !$failed,
            'message' => $failed ? trans('footer.subscribe_error') : trans('footer.subscribe_success'),
            'error' => NewsletterFacade::getLastError(),
        ];
    }
}
