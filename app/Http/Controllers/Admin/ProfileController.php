<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show()
    {
        $user = request()->user();

        return [
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

    public function update()
    {
        request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
        ]);
        $user = request()->user();
        $user->update(request()->only('name', 'email'));

        return [
            'name' => $user->fresh()->name,
            'email' => $user->fresh()->email,
        ];
    }
}
