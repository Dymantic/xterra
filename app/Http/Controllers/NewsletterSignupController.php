<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Newsletter\NewsletterFacade;

class NewsletterSignupController extends Controller
{
    public function store()
    {

        request()->validate([
            'email' => ['required', 'email'],
        ]);

        $subscribed = NewsletterFacade::subscribeOrUpdate(request('email'), [
            'FNAME' => request('name', '')
        ]);

        $message = $subscribed === false ?
            trans('footer.subscribe_error', ['email' => request('email')]) :
            trans('footer.subscribe_success');

        return [
            'subscribed' => $subscribed !== false,
            'message'    => $message,
            'error'      => NewsletterFacade::getLastError(),
        ];
    }
}
