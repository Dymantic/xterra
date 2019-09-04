<?php

namespace App\Blog;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Translation extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'language', 'intro', 'description', 'body', 'author_name'];

    protected $dates = ['first_published_on', 'published_on'];

    protected $casts = ['is_published' => 'boolean'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => !$this->hasBeenPublishedBefore(),
            ]
        ];
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function setTags($tags)
    {
        $tag_ids = collect($tags)
            ->reject(function($tagName) {
                return !is_string($tagName) || !$tagName;
            })
            ->map(function ($tagName) {
                return Tag::firstOrCreate(['tag_name' => strtolower($tagName)])->id;
            });

        $this->tags()->sync($tag_ids->all());
    }

    public function getTags()
    {
        return $this->tags->pluck('tag_name')->all();
    }

    public function publish($date = null)
    {
        $publish_date = Carbon::parse($date);

        if(!$this->hasBeenPublishedBefore()) {
            $this->first_published_on = $publish_date;
        }

        $this->published_on = $publish_date;
        $this->is_published = true;
        $this->save();
    }

    private function hasBeenPublishedBefore()
    {
        return !! $this->first_published_on;
    }

    public function retract()
    {
        $this->is_published = false;
        $this->save();
    }

    public function isLive()
    {
        if(!$this->is_published) {
            return false;
        }

        return $this->published_on->startOfDay()->isBefore(Carbon::now());
    }


}
