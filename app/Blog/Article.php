<?php

namespace App\Blog;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Article extends Model
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'sluggableString'
            ]
        ];
    }

    public function getSluggableStringAttribute()
    {
        return Carbon::today()->format('Y-m-d');
    }

    public static function makeWithTranslation($lang, $title, $author)
    {
        $article = static::create();

        $article->addTranslation($lang, $title, $author);

        return $article;
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function addTranslation($lang, $title, $author)
    {
        return $this->translations()->create([
            'language' => $lang,
            'title' => $title,
            'author_name' => $author->name,
        ]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
