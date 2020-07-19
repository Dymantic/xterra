<?php

namespace App\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Gallery extends Model implements HasMedia
{
    use HasMediaTrait;

    const IMAGES = 'images';

    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'title'       => 'array',
        'description' => 'array',
    ];

    public function addImage(UploadedFile $file): Media
    {
        return $this->addMedia($file)
            ->usingFileName($file->hashName())
            ->toMediaCollection(self::IMAGES);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 500, 333)
             ->optimize()
             ->performOnCollections(self::IMAGES);

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_CROP, 1800, 1200)
             ->optimize()
             ->performOnCollections(self::IMAGES);
    }

    public function setOrder(array $image_ids)
    {
        collect($image_ids)
            ->map(fn ($id) => Media::find($id))
            ->reject(fn ($media) => !$media)
            ->each(fn ($media, $position) => $this->setImagePosition($media, $position));
    }

    private function setImagePosition(Media $image, int $position)
    {
        $image->setCustomProperty('position', $position);
        $image->save();
    }
}
