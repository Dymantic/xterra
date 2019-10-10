<?php

namespace App\Blog;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;

    protected $guarded = [];

    protected $casts = ['title' => 'array', 'description' => 'array'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'sluggableTitle'
            ]
        ];
    }

    public function getSluggableTitleAttribute()
    {
        return $this->title['en'] ?? '';
    }

    public static function createNew($attributes)
    {
        return static::create([
            'title' => [
                'en' => $attributes['title']['en'],
                'zh' => $attributes['title']['zh'] ?? "",
            ],
            'description' => [
                'en' => $attributes['description']['en'] ?? "",
                'zh' => $attributes['description']['zh'] ?? "",
            ]
        ]);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function safeDelete()
    {
        $this->articles()->sync([]);

        $this->delete();
    }
}
