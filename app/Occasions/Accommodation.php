<?php

namespace App\Occasions;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'link',
        'phone',
        'email',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];
}
