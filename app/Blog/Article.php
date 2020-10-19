<?php

namespace App\Blog;

use App\Media\Cardable;
use App\Media\ContentCardInfo;
use App\Slider\Slide;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia, Cardable
{
    use Sluggable, InteractsWithMedia;

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

    public function registerMediaConversions(Media $media = null): void
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

        $this->addMediaConversion('banner_mobile')
             ->fit(Manipulations::FIT_CROP, 900, 900)
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


    public function cardInfo(): ContentCardInfo
    {
        $this->load('translations');
        $en = $this->translations->first(fn($t) => $t->language === 'en');
        $zh = $this->translations->first(fn($t) => $t->language === 'zh');
        $title_image = $this->getFirstMedia(self::TITLE_IMAGES);

        return new ContentCardInfo([
            'category' => [
                'en' => Lang::get('content-cards.blog', [], 'en'),
                'zh' => Lang::get('content-cards.blog', [], 'zh'),
            ],
            'title' => [
                'en' => $en ? $en->title : '',
                'zh' => $zh ? $zh->title : '',
            ],
            'link' => "/blog/{$this->slug}/",
            'image_path' => $title_image ? Storage::disk('media')->path(Str::after($title_image->getUrl(), "/media/")) : '',
        ]);
    }
}
