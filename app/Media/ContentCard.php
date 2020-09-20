<?php

namespace App\Media;

use App\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class ContentCard extends Model implements HasMedia
{

    use HasMediaTrait;

    const IMAGE = 'image';
    const DEFAULT_IMAGE = '/images/default_image.svg';

    protected $fillable = ['title', 'category', 'link'];

    protected $casts = [
        'title' => Translation::class,
        'category' => Translation::class,
    ];

    public static function new(ContentCardInfo $cardInfo): self
    {
        return self::create($cardInfo->toArray());
    }

    public static function fromExistingContent(Cardable $cardable): self
    {
        $info = $cardable->cardInfo();
        $card = self::create($info->toArray());

        if($info->image_path && file_exists($info->image_path)) {
            $card->addMedia($info->image_path)
                ->preservingOriginal()
                ->toMediaCollection(self::IMAGE);
        }

        return $card;
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
        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_CROP, 900, 600)
             ->optimize()
             ->performOnCollections(self::IMAGE);
    }

    public function toArray()
    {
        $image = $this->getFirstMedia(self::IMAGE);

        return [
            'id' => $this->id,
            'category' => $this->category->toArray(),
            'title' => $this->title->toArray(),
            'link' => $this->link,
            'image' => [
                'web' => $image ? $image->getUrl('web') : self::DEFAULT_IMAGE,
                'original' => $image ? $image->getUrl() : self::DEFAULT_IMAGE,
            ]

        ];
    }
}
