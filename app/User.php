<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['retired_on'];

    public static function register($user_data)
    {
        return static::create([
            'name' => $user_data['name'],
            'email' => $user_data['email'],
            'password' => Hash::make($user_data['password']),
        ]);
    }

    public function resetPassword($password)
    {
        $this->password = Hash::make($password);
        return $this->save();
    }

    public function retire()
    {
        $this->retired_on = Carbon::now();
        $this->save();
    }

    public function isRetired()
    {
        return !! $this->retired_on;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_retired' => $this->isRetired(),
            'retired_date' => $this->retired_on ? $this->retired_on->format('j M, Y') : ''
        ];
    }
}
