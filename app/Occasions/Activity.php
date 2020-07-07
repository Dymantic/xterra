<?php

namespace App\Occasions;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    const RUN = 'run';
    const SWIM = 'swim';
    const CYCLE = 'cycle';
    const TRAINING = 'training';
    const SEMINAR = 'seminar';
    const LIFESTYLE = 'lifestyle';
    const NO_CATEGORY = 'other';

    const ACTIVITY_TYPES = [
        self::RUN,
        self::SWIM,
        self::CYCLE,
        self::SEMINAR,
        self::LIFESTYLE,
        self::NO_CATEGORY,
        self::TRAINING,
    ];

    protected $fillable = [
        'name',
        'description',
        'distance',
        'category',
        'is_race',
    ];

    protected $casts = [
        'name' => 'array',
        'distance' => 'array',
        'description' => 'array',
    ];
}
