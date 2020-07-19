<?php

namespace App\Media;

use Illuminate\Database\Eloquent\Model;

class EmbeddableVideo extends Model
{
    const YOUTUBE = 'youtube';

    protected $fillable = [
        'platform',
        'video_id',
        'title',
    ];

    protected $casts = ['title' => 'array'];

    public function videoed()
    {
        return $this->morphTo();
    }
}
