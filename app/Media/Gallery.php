<?php

namespace App\Media;

use App\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Gallery extends Model implements HasMedia
{
    use InteractsWithMedia;

    const IMAGES = 'images';

    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'title'       => Translation::class,
        'description' => Translation::class,
    ];

    public function addImage(UploadedFile $file): Media
    {
        return $this->addMedia($file)
                    ->usingFileName($file->hashName())
                    ->toMediaCollection(self::IMAGES);
    }

    public function registerMediaConversions(Media $media = null): void
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
            ->map(fn($id) => Media::find($id))
            ->reject(fn($media) => !$media)
            ->each(fn($media, $position) => $this->setImagePosition($media, $position));
    }

    private function setImagePosition(Media $image, int $position)
    {
        $image->setCustomProperty('position', $position);
        $image->save();
    }

    public function toArray()
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title->toArray(),
            'description' => $this->description->toArray(),
            'images'      => $this->getMedia(self::IMAGES)->map(fn(Media $media) => [
                'id'       => $media->id,
                'thumb'    => $media->getUrl('thumb'),
                'web'      => $media->getUrl('web'),
                'original' => $media->getUrl(),
                'position' => $media->getCustomProperty('position'),
            ])->sortBy('position')->values()->all(),
        ];
    }

    public function presentForLang($lang)
    {
        return [
            'title'       => $this->title->in($lang),
            'description' => $this->description->in($lang),
            'images'      => $this->getMedia(self::IMAGES)->map(fn(Media $media) => [
                'id'       => $media->id,
                'thumb'    => $media->getUrl('thumb'),
                'web'      => $media->getUrl('web'),
                'original' => $media->getUrl(),
                'position' => $media->getCustomProperty('position'),
            ])->sortBy('position')->values()->all(),
        ];
    }
}
