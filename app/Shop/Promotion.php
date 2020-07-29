<?php

namespace App\Shop;

use App\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Promotion extends Model implements HasMedia
{
    use HasMediaTrait;

    const IMAGE = 'image';

    protected $fillable = ['title', 'writeup', 'link', 'button_text'];

    protected $casts = [
        'title'       => Translation::class,
        'writeup'     => Translation::class,
        'button_text' => Translation::class,
        'is_public'   => 'boolean',
        'is_featured'   => 'boolean',
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
}
