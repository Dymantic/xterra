<?php

namespace App\Shop;

use App\Media\Cardable;
use App\Media\ContentCardInfo;
use App\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Promotion extends Model implements HasMedia, Cardable
{
    use HasMediaTrait;

    const IMAGE = 'image';
    const DEFAULT_IMAGE = '/images/default_image.svg';

    protected $fillable = ['title', 'writeup', 'link', 'button_text'];

    protected $casts = [
        'title'       => Translation::class,
        'writeup'     => Translation::class,
        'button_text' => Translation::class,
        'is_public'   => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function scopeFeatured($query)
    {
        $query->where('is_featured', true);
    }

    public static function new(PromotionInfo $info): self
    {
        return self::create($info->toArray());
    }

    public function publish()
    {
        $this->is_public = true;
        $this->save();
    }

    public function retract()
    {
        $this->is_public = false;
        $this->save();
    }

    public function feature()
    {
        $this->featured()->get()->map->unfeature();

        $this->is_featured = true;
        $this->save();

        $this->publish();
    }

    public function unfeature()
    {
        $this->is_featured = false;
        $this->save();
    }

    public function setImage(UploadedFile $upload): Media
    {
        $this->clearImage();

        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::IMAGE);
    }

    public function clearImage()
    {
        $this->clearMediaCollection(self::IMAGE);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 600, 400)
             ->optimize()
             ->performOnCollections(self::IMAGE);

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_CROP, 1200, 800)
             ->optimize()
             ->performOnCollections(self::IMAGE);
    }

    public function toArray()
    {
        $image = $this->getFirstMedia(self::IMAGE);

        return [
            'id'          => $this->id,
            'link'        => $this->link,
            'title'       => $this->title->toArray(),
            'writeup' => $this->writeup->toArray(),
            'button_text' => $this->button_text->toArray(),
            'image'       => [
                'id'       => $image ? $image->id : null,
                'thumb'    => $image ? $image->getUrl('thumb') : self::DEFAULT_IMAGE,
                'web'      => $image ? $image->getUrl('web') : self::DEFAULT_IMAGE,
                'original' => $image ? $image->getUrl() : self::DEFAULT_IMAGE,
            ]
        ];
    }

    public function cardInfo(): ContentCardInfo
    {
        $image = $this->getFirstMedia(self::IMAGE);

        return new ContentCardInfo([
            'category' => [
                'en' => Lang::get('content-cards.shop', [], 'en'),
                'zh' => Lang::get('content-cards.shop', [], 'zh'),
            ],
            'title' => $this->title->toArray(),
            'link' => $this->link,
            'image_path' => $image ? Storage::disk('media')->path(Str::after($image->getUrl(), "/media/")) : ''
        ]);
    }
}
