<?php

namespace App\Occasions;

use Illuminate\Database\Eloquent\Model;

class TravelRoute extends Model
{
    protected $fillable = ['name', 'description'];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];
}
