<?php

namespace App\Occasions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Course extends Model implements HasMedia
{
    use InteractsWithMedia;

    const GPX_DISK = 'admin_uploads';
    const IMAGES = 'images';

    protected $fillable = [
        'name',
        'distance',
        'description',
    ];

    protected $casts = [
        'name'        => 'array',
        'distance'    => 'array',
        'description' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function setGPXFile(UploadedFile $file)
    {
        $this->clearGPXFile();
        $path = $file->store('gpx', self::GPX_DISK);

        $this->gpx_filename = $path;
        $this->gpx_disk = self::GPX_DISK;
        $this->save();
    }

    public function clearGPXFile()
    {
        if(Storage::disk($this->gpx_disk)->exists($this->gpx_filename)) {
            Storage::disk($this->gpx_disk)->delete($this->gpx_filename);
        }

        $this->gpx_filename = null;
        $this->gpx_disk = null;
        $this->save();
    }

    public function getGPXFileUrl(): string
    {
        if(Storage::disk($this->gpx_disk)->exists($this->gpx_filename)) {
            return sprintf("/%s/%s", $this->gpx_disk, $this->gpx_filename);
        }

        return '';
    }

    public function addImage(UploadedFile $file): Media
    {
        return $this->addMedia($file)
                    ->preservingOriginal()
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
             ->fit(Manipulations::FIT_MAX, 1200, 800)
             ->optimize()
             ->performOnCollections(self::IMAGES);
    }

    public function setImagePositions(array $image_ids)
    {
        collect($image_ids)
            ->map(fn ($id) => Media::find($id))
            ->reject(fn ($image) => !($image instanceof Media))
            ->each(fn (Media $media, $position) => $this->updateMediaPosition($media, $position));

    }

    private function updateMediaPosition(Media $image, int $position)
    {
        $image->setCustomProperty('position', $position);
        $image->save();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'race_id' => $this->activity_id,
            'name' => $this->name,
            'distance' => $this->distance,
            'description' => $this->description,
            'gallery' => $this->getMedia(self::IMAGES)->map(fn (Media $image) => [
                'id' => $image->id,
                'thumb' => $image->getUrl('thumb'),
                'web' => $image->getUrl('web'),
                'original' => $image->getUrl(),
                'position' => $image->getCustomProperty('position')
            ])->sortBy('position')->values()->all(),
            'gpx_file' => $this->getGPXFileUrl(),

        ];
    }

    public function presentForLang($lang)
    {
        return [
            'name' => $this->name[$lang] ?? '',
            'distance' => $this->distance[$lang] ?? '',
            'description' => $this->description[$lang] ?? '',
            'gallery' => $this->getMedia(self::IMAGES)->map(fn (Media $image) => [
                'id' => $image->id,
                'thumb' => $image->getUrl('thumb'),
                'web' => $image->getUrl('web'),
                'original' => $image->getUrl(),
                'position' => $image->getCustomProperty('position')
            ])->sortBy('position')->values()->all(),
            'gpx_file' => $this->getGPXFileUrl(),
        ];
    }
}
