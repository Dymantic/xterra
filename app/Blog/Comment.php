<?php

namespace App\Blog;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use CanBeFlagged;

    protected $fillable = ['author', 'fb_id', 'body'];

    public function translation()
    {
        return $this->belongsTo(Translation::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function addReply($data)
    {
        return $this->replies()->create($data);
    }

    public function flagged()
    {
        return $this->morphOne(FlaggedComment::class, 'flaggable');
    }


    public function safeDelete()
    {
        if($this->flagged) {
            $this->flagged->delete();
        }
        $this->replies->each->delete();
        $this->delete();
    }

    public function asInfoForReview()
    {
        return [
            'id'                => $this->id,
            'author'            => $this->author,
            'fb_id'             => $this->fb_id,
            'body'              => $this->body,
            'replies'           => $this->replies->map->toArray(),
            'time_ago'          => $this->created_at->diffForHumans(),
            'timestamp'         => $this->created_at->timestamp,
            'created_at'        => $this->created_at->format('j M, Y'),
            'translation_title' => $this->translation->title,

        ];
    }

    public function toArray()
    {
        return [
            'id'         => $this->id,
            'author'     => $this->author,
            'fb_id'      => $this->fb_id,
            'body'       => $this->body,
            'replies'    => $this->replies->map->toArray()->all(),
            'time_ago'   => $this->created_at->diffForHumans(),
            'timestamp'  => $this->created_at->timestamp,
            'created_at' => $this->created_at->format('j M, Y'),
            'is_flagged' => !! $this->flagged()->count(),
        ];
    }
}
