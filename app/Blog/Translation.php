<?php

namespace App\Blog;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Translation extends Model implements HasMedia
{
    use Sluggable, HasMediaTrait;

    const BODY_IMAGES = 'body-images';

    protected $fillable = ['title', 'language', 'intro', 'description', 'body', 'author_name'];

    protected $dates = ['first_published_on', 'published_on'];

    protected $casts = ['is_published' => 'boolean'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source'   => 'title',
                'onUpdate' => !$this->hasBeenPublishedBefore(),
            ]
        ];
    }

    public function getFullSlugAttribute()
    {
        return "{$this->article->slug}/{$this->slug}";
    }

    public function scopeLive($query)
    {
        return $query->where('is_published', true)->where('published_on', '<=', Carbon::today()->startOfDay());
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function setTags($tags)
    {
        $tag_ids = collect($tags)
            ->reject(function ($tagName) {
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

        if (!$this->hasBeenPublishedBefore()) {
            $this->first_published_on = $publish_date;
        }

        $this->published_on = $publish_date;
        $this->is_published = true;
        $this->save();
    }

    private function hasBeenPublishedBefore()
    {
        return !!$this->first_published_on;
    }

    public function retract()
    {
        $this->is_published = false;
        $this->save();
    }

    public function isLive()
    {
        if (!$this->is_published) {
            return false;
        }

        return $this->published_on->startOfDay()->isBefore(Carbon::now());
    }

    public function attachImage($file)
    {
        return $this->addMedia($file)->toMediaCollection(static::BODY_IMAGES);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_MAX, 1000, 2000)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(static::BODY_IMAGES);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment($data)
    {
        return $this->comments()->create($data);
    }

    public function related($lang)
    {
        $related = collect($this->sharesCategoryAndTag([], $lang));

        if ($related->count() > 2) {
            return $related;
        }

        $related->concat($this->sharesCategory($related->pluck('id')->all(), $lang));

        if ($related->count() > 2) {
            return $related->take(3);
        }


        $related->concat($this->sharesTag($related->pluck('id')->all(), $lang));

        if ($related->count() > 2) {
            return $related->take(3);
        }

        $filler = static::with('article', 'article.categories', 'article.media', 'tags')
                        ->where('language', $lang)
                        ->live()
                        ->whereNotIn('id', array_merge([$this->id], $related->pluck('id')->all()))
                        ->latest('published_on')
                        ->take(3)->get();

        $related = $related->concat($filler);

        return $related->take(3);
    }

    private function sharesCategoryAndTag($excludes, $lang)
    {
        return static::with('article', 'article.categories', 'article.media', 'tags')
                     ->where('language', $lang)
                     ->live()
                     ->whereNotIn('id', array_merge([$this->id], $excludes))
                     ->whereHas('article.categories', function ($query) {
                         $query->whereIn('categories.id', $this->article->categories->pluck('id')->all());
                     })
                     ->whereHas('tags', function ($query) {
                         return $query->whereIn('tags.id', $this->tags->pluck('id')->all());
                     })
                     ->latest('published_on')
                     ->take(3)->get();
    }

    private function sharesCategory($excludes, $lang)
    {
        return static::with('article', 'article.categories', 'article.media', 'tags')
                     ->where('language', $lang)
                     ->live()
                     ->whereNotIn('id', array_merge([$this->id], $excludes))
                     ->whereHas('article.categories', function ($query) {
                         $query->whereIn('categories.id', $this->article->categories->pluck('id')->all());
                     })
                     ->latest('published_on')
                     ->take(3)->get();
    }

    private function sharesTag($excludes, $lang)
    {
        return static::with('article', 'article.categories', 'article.media', 'tags')
                     ->where('language', $lang)
                     ->live()
                     ->whereNotIn('id', array_merge([$this->id], $excludes))
                     ->whereHas('tags', function ($query) {
                         return $query->whereIn('tags.id', $this->tags->pluck('id')->all());
                     })
                     ->latest('published_on')
                     ->take(3)->get();
    }

    public function toArray()
    {
        return [
            'id'                        => $this->id,
            'article_id'                => $this->article_id,
            'language'                  => $this->language,
            'title'                     => $this->title,
            'slug'                      => $this->slug,
            'canonical_url'             => "/{$this->language}/blog/{$this->article->slug}",
            'full_slug'                 => $this->fullSlug,
            'intro'                     => $this->intro,
            'description'               => $this->description,
            'body'                      => $this->body,
            'first_published'           => $this->first_published_on ? $this->first_published_on->format('j M, Y') : null,
            'publish_date'              => $this->published_on ? $this->published_on->format('m/d/Y') : null,
            'publish_date_formatted'    => $this->published_on ? $this->published_on->format('Y-m-d') : null,
            'first_published_formatted' => $this->first_published_on ? $this->first_published_on->format('Y-m-d') : null,
            'is_published'              => $this->is_published,
            'is_live'                   => $this->isLive(),
            'author_name'               => $this->author_name,
            'tags'                      => $this->tags->map->toArray()->all(),
            'title_image'               => [
                'thumb'  => $this->article->titleImage('thumb') ?? '/images/default.jpg',
                'web'    => $this->article->titleImage('web'),
                'banner' => $this->article->titleImage('banner'),
            ],
            'categories'                => $this->article->categories->map->toArray()->all(),
        ];
    }


}
