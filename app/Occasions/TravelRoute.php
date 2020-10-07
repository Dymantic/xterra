<?php

namespace App\Occasions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class TravelRoute extends Model implements HasMedia
{
    use HasMediaTrait;

    const IMAGE = 'image';

    protected $fillable = ['name', 'description'];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

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
        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_MAX, 1200, 1200)
             ->optimize()
             ->performOnCollections(self::IMAGE);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => optional($this->getFirstMedia(self::IMAGE))->getUrl('web'),
        ];
    }
}
