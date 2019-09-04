<?php


namespace App\Providers;


use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class NonRetiredUserProvider extends EloquentUserProvider
{
    public function validateCredentials(UserContract $user, array $credentials)
    {
        if($user->isRetired()) {
            return false;
        }

        $plain = $credentials['password'];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }
}