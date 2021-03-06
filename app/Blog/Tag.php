<?php

namespace App\Blog;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Sluggable;

    protected $fillable = ['tag_name'];

    public function sluggable(): array
    {
        return [
            'slug' => ['source' => 'tag_name']
        ];
    }

    public function translations()
    {
        return $this->belongsToMany(Translation::class);
    }

    public function scopeInUse($query)
    {
        return $query->withCount('translations')
            ->whereHas('translations', function($q) {
                $q->live();
            });
//                     ->groupBy('tag_name')
//                     ->having('translations_count', '>', 0);
    }

    public function scopeForLang($query, $lang)
    {
        return $query->whereHas('translations', function($q) use ($lang) {
            $q->where('language', $lang);
        });
    }

    public function scopeForChinese($query)
    {
        return $query->whereHas('translations', function($q) {
            $q->where('language', 'zh');
        });
    }

    public function toArray()
    {
        return [
            'id'       => $this->id,
            'tag_name' => $this->tag_name,
            'slug'     => $this->slug,
        ];
    }

    public function toArrayWithCount()
    {
        return [
            'id'       => $this->id,
            'tag_name' => $this->tag_name,
            'slug'     => $this->slug,
            'translations_count' => $this->translations_count,
        ];
    }
}
