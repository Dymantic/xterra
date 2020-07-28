<?php

namespace App\Media;

use App\Translation;
use Illuminate\Database\Eloquent\Model;

class EmbeddableVideo extends Model
{
    const YOUTUBE = 'youtube';

    protected $fillable = [
        'platform',
        'video_id',
        'title',
    ];

    protected $casts = ['title' => Translation::class];

    public function videoed()
    {
        return $this->morphTo();
    }

    public function updateTitle(Translation $title)
    {
        $this->title = $title;
        $this->save();
    }
}
