<?php

namespace App\Pages;

use App\Translation;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Page extends Model implements HasMedia
{
    use HasMediaTrait, Sluggable;

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

    public static function new(PageInfo $info): self
    {
        return self::create($info->toArray());
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

    public function saveImage(UploadedFile  $upload): Media
    {
        return $this->addMedia($upload)
            ->usingFileName($upload->hashName())
            ->toMediaCollection(self::CONTENT_IMAGES);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('web')
            ->fit(Manipulations::FIT_CONTAIN, 1500, 2000)
            ->optimize()
            ->performOnCollections(self::CONTENT_IMAGES);
    }
}
