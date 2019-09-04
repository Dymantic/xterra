<?php

namespace App\Http\Controllers\Admin;

use App\Rules\CurrentPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPasswordController extends Controller
{
    public function update()
    {
        $user = request()->user();

        request()->validate([
            'current_password' => [new CurrentPassword($user)],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $user->resetPassword(request('password'));
    }
}
