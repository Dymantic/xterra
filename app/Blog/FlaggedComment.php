<?php

namespace App\Blog;

use Illuminate\Database\Eloquent\Model;

class FlaggedComment extends Model
{
    protected $fillable = ['reason'];

    public function flaggable()
    {
        return $this->morphTo();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'reason' => $this->reason,
            'type' => $this->flaggable_type === Comment::class ? 'comment' : 'reply',
            'context' => $this->flaggable->body,
            'original_author' => $this->flaggable->author,
            'flagged_on' => $this->created_at->format('j M, Y')
        ];
    }
}
