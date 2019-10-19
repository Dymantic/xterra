<?php

namespace App\Blog;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use CanBeFlagged;

    protected $fillable = ['author', 'fb_id', 'body'];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function flagged()
    {
        return $this->morphOne(FlaggedComment::class, 'flaggable');
    }

    public function asInfoForReview()
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'fb_id' => $this->fb_id,
            'body' => $this->body,
            'time_ago' => $this->created_at->diffForHumans(),
            'timestamp' => $this->created_at->timestamp,
            'created_at' => $this->created_at->format('j M, Y'),
            'comment' => $this->comment->body,
        ];
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'fb_id' => $this->fb_id,
            'body' => $this->body,
            'time_ago' => $this->created_at->diffForHumans(),
            'created_at' => $this->created_at->format('j M, Y'),
            'is_flagged' => !! $this->flagged()->count(),
        ];
    }
}
