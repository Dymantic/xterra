<?php

namespace App\Blog;

use App\Slider\Slide;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Article extends Model implements HasMedia
{
    use Sluggable, HasMediaTrait;

    const TITLE_IMAGES = 'title_images';

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

    public function safeDelete()
    {
        $this->slides->each->delete();
        $this->translations->each->delete();
        $this->delete();
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function liveTranslations()
    {
        return $this->translations()->live()->pluck('language');
    }

    public function addTranslation($lang, $title, $author)
    {
        return $this->translations()->create([
            'language'    => $lang,
            'title'       => $title,
            'author_name' => $author->name,
        ]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function slides()
    {
        return $this->hasMany(Slide::class);
    }

    public function titleImage($conversion = '')
    {
        $image = $this->getFirstMedia(static::TITLE_IMAGES);

        return $image ? $image->getUrl($conversion) : '/images/default.jpg';
    }

    public function setTitleImage($file)
    {
        $this->clearMediaCollection(static::TITLE_IMAGES);

        return $this->addMedia($file)
                    ->usingFileName(Str::random(10))
                    ->toMediaCollection(static::TITLE_IMAGES);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 450, 300)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(static::TITLE_IMAGES);

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_CROP, 1200, 800)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(static::TITLE_IMAGES);

        $this->addMediaConversion('banner')
             ->fit(Manipulations::FIT_CROP, 1800, 900)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(static::TITLE_IMAGES);

        $this->addMediaConversion('share')
             ->fit(Manipulations::FIT_CROP, 1200, 630)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(static::TITLE_IMAGES);
    }

    public function toArray()
    {
        return [
            'id'           => $this->id,
            'categories'   => $this->categories->map->toArray()->all(),
            'translations' => $this->translations->toArray(),
            'slug'         => $this->slug,
            'title_image'  => [
                'thumb'    => $this->titleImage('thumb'),
                'web'      => $this->titleImage('web'),
                'banner'   => $this->titleImage('banner'),
                'original' => $this->titleImage(),
            ]

        ];
    }


}
