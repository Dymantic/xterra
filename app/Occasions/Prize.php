<?php

namespace App\Occasions;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $fillable = ['category', 'prize', 'position'];

    protected $casts = [
        'category' => 'array',
        'prize' => 'array',
    ];
}
