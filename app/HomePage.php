<?php

namespace App;

use App\Campaigns\Campaign;
use App\Occasions\Event;
use App\Shop\Promotion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class HomePage extends Model implements HasMedia
{
    use HasMediaTrait;

    const BANNER_IMG = 'banner_img';

    public static function current(): self
    {
        return self::firstOrCreate([]);
    }

    public function setBannerImage(UploadedFile $upload): Media
    {
        $this->clearBannerImage();

        return $this->addMedia($upload)
            ->usingFileName($upload->hashName())
            ->toMediaCollection(self::BANNER_IMG);
    }

    public function clearBannerImage()
    {
        $this->clearMediaCollection(self::BANNER_IMG);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('full')
             ->fit(Manipulations::FIT_CROP, 2000, 1125)
             ->optimize()
             ->performOnCollections(self::BANNER_IMG);

        $this->addMediaConversion('small')
             ->fit(Manipulations::FIT_CROP, 1000, 1000)
             ->optimize()
             ->performOnCollections(self::BANNER_IMG);
    }

    public function featurePromotion(Promotion $promotion)
    {
        $this->promotion_id = $promotion->id;
        $this->save();
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function featureEvent(Event $event)
    {
        $this->event_id = $event->id;
        $this->save();
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function featureCampaign(Campaign $campaign)
    {
        $this->campaign_id = $campaign->id;
        $this->save();
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
