<?php

namespace App\Pages;

use App\JsonToBladeParser;
use App\Translation;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia, Sluggable;

    const CONTENT_IMAGES = 'content-images';

    protected $fillable = [
        'title',
        'description',
        'blurb',
        'content',
        'menu_name'
    ];

    protected $dates = ['first_published'];

    protected $casts = [
        'title'       => Translation::class,
        'description' => Translation::class,
        'blurb'       => Translation::class,
        'content'     => Translation::class,
        'menu_name'   => Translation::class,
        'is_public'   => 'boolean',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'sluggableTitle',
                'onUpdate' => $this->isDraft(),
            ]
        ];
    }

    public function getSluggableTitleAttribute()
    {
        return $this->title->in('en');
    }

    public function scopeLive($query)
    {
        return $query->where('is_public', true);
    }

    public static function new(PageMetaInfo $info): self
    {
        return self::create(
            array_merge(
                $info->toArray(),
                ['content' => new Translation(['en' => '', 'zh' => ''])]
            )
        );
    }

    public function publish()
    {
        if($this->isDraft()) {
            $this->first_published = now();
        }

        $this->is_public = true;
        $this->save();
    }

    public function isDraft(): bool
    {
        return $this->first_published === null;
    }

    public function retract()
    {
        $this->is_public = false;
        $this->save();
    }

    public function setContent($contents, $lang)
    {
        $this->content = new Translation(array_merge($this->content->toArray(), [$lang => $contents]));
        $this->save();
    }

    public function contentHtml($lang)
    {
        $parser = new JsonToBladeParser('editorjs.pages');

        return $parser->html($this->content->translations[$lang]);
    }

    public function saveImage(UploadedFile  $upload): Media
    {
        return $this->addMedia($upload)
            ->usingFileName($upload->hashName())
            ->toMediaCollection(self::CONTENT_IMAGES);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('web')
            ->fit(Manipulations::FIT_CONTAIN, 1500, 2000)
            ->optimize()
            ->performOnCollections(self::CONTENT_IMAGES);
    }

    public function presentForAdmin()
    {
        return PagePresenter::forAdmin($this);
    }
}
