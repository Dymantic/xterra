<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    public function index()
    {
        return User::all();
    }

    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        return User::register(request()->only('name', 'email', 'password'));
    }

    public function destroy(User $user)
    {
        $user->retire();
    }
}
