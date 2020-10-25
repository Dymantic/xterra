<?php

namespace App\Occasions;

use App\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Sponsor extends Model implements HasMedia
{

    use InteractsWithMedia;

    const LOGO = 'logo';

    protected $fillable = ['name', 'description', 'link', 'position'];

    protected $casts = [
        'name'        => Translation::class,
        'description' => Translation::class,
        'position'    => 'integer',
    ];

    public static function setOrder(array $sponsor_ids)
    {
        collect($sponsor_ids)
            ->each(fn($id, $position) => self::find($id)->update(['position' => $position + 1]));
    }


    public function setLogo(UploadedFile $upload): Media
    {
        $this->clearLogo();

        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::LOGO);
    }

    public function clearLogo()
    {
        $this->clearMediaCollection(self::LOGO);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_MAX, 500, 333)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(self::LOGO);
    }

    public function toArray()
    {
        $logo = $this->getFirstMedia(self::LOGO);

        return [
            'id'          => $this->id,
            'name'        => $this->name->toArray(),
            'description' => $this->description->toArray(),
            'link'        => $this->link,
            'logo'        => [
                'thumb'    => optional($logo)->getUrl('thumb'),
                'original' => optional($logo)->getUrl(),
            ]
        ];
    }

    public function presentForLang($lang)
    {
        $logo = $this->getFirstMedia(self::LOGO);

        return [
            'name'        => $this->name->in($lang),
            'description' => $this->description->in($lang),
            'link'        => $this->link,
            'logo'        => [
                'thumb'    => optional($logo)->getUrl('thumb'),
                'original' => optional($logo)->getUrl(),
            ]
        ];
    }

}
