<?php

namespace App\Occasions;

use App\HasEmbeddedVideos;
use App\HasPromoVideo;
use App\Media\Cardable;
use App\Media\ContentCardInfo;
use App\Media\EmbeddableVideo;
use App\Media\Gallery;
use App\Translation;
use App\UniqueKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia, Cardable
{
    use HasActivities, HasSchedule, HasFees, HasTravelRoutes, HasAccommodation, HasEmbeddedVideos, InteractsWithMedia, HasPromoVideo, HasSponsors, HasAttendees, Searchable;

    const TRAVEL_GUIDE_DISK = 'admin_uploads';
    const BANNER_IMAGE = 'banner_image';
    const MOBILE_BANNER = 'mobile_banner_image';
    const CARD_IMAGE = 'card_image';
    const DEFAULT_IMAGE = '/images/default_image.svg';
    const DEFAULT_BANNER = '/images/default_home_banner.jpg';

    protected $fillable = [
        'name',
        'intro',
        'slug',
        'location',
        'venue_name',
        'venue_address',
        'venue_maplink',
        'start',
        'end',
        'registration_link',
        'overview'
    ];

    protected $casts = [
        'name'          => 'array',
        'intro'          => 'array',
        'location'      => 'array',
        'venue_name'    => 'array',
        'venue_address' => 'array',
        'overview'      => Translation::class,
        'is_public'     => 'boolean',
    ];

    protected $dates = ['start', 'end'];

    public function shouldBeSearchable()
    {
        return $this->is_public;
    }

    public static function createWithName($name): Event
    {
        return static::create([
            'name'          => [
                'en' => $name['en'] ?? '',
                'zh' => $name['zh'] ?? '',
            ],
            'slug'          => UniqueKey::for('events:slug', 4),
            'location'      => ['en' => '', 'zh' => ''],
            'venue_name'    => ['en' => '', 'zh' => ''],
            'venue_address' => ['en' => '', 'zh' => ''],
            'overview'      => new Translation(['en' => '', 'zh' => '']),
        ]);
    }

    public function updateGeneralInfo(GeneralEventInfo $info)
    {
        $this->update($info->toArray());
    }

    public function scopeLive($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('end', '>=', now()->startOfDay());
    }

    public function scopePast($query)
    {
        return $query->where('end', '<=', now()->startOfDay());
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

    public function setOverview(Translation $overview)
    {
        $this->overview = $overview;
        $this->save();
    }

    public function setTravelGuide(UploadedFile $file)
    {
        $path = $file->store('travel', self::TRAVEL_GUIDE_DISK);

        $this->travel_guide = $path;
        $this->travel_guide_disk = self::TRAVEL_GUIDE_DISK;
        $this->save();
    }

    public function clearTravelGuide()
    {
        if ($this->travel_guide && Storage::disk($this->travel_guide_disk)->exists($this->travel_guide)) {
            Storage::disk($this->travel_guide_disk)->delete($this->travel_guide);
        }

        $this->travel_guide = null;
        $this->travel_guide_disk = null;
        $this->save();
    }

    public function getTravelGuideUrl(): string
    {
        if ($this->travel_guide && Storage::disk($this->travel_guide_disk)->exists($this->travel_guide)) {
            return sprintf("/%s/%s", $this->travel_guide_disk, $this->travel_guide);
        }

        return "";
    }

    function presentForAdmin()
    {
        return EventPresenter::forAdmin($this);
    }

    public function presentForLang($lang) {
        return EventPresenter::forPublic($this, $lang);
    }

    public function galleries()
    {
        return $this->belongsToMany(Gallery::class);
    }

    public function addGallery($gallery_id)
    {
        $this->galleries()->attach($gallery_id);
    }

    public function removeGallery($gallery_id)
    {
        $this->galleries()->detach($gallery_id);
    }

    public function setBannerImage(UploadedFile $upload): Media
    {
        $this->clearBannerImage();

        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::BANNER_IMAGE);
    }

    public function getBannerImage($default = self::DEFAULT_IMAGE)
    {
        $image = $this->getFirstMedia(self::BANNER_IMAGE);

        return [
            'original' => $image ? $image->getUrl() : $default,
            'banner'   => $image ? $image->getUrl('banner') : $default,
        ];
    }

    public function getMobileBanner($default = self::DEFAULT_IMAGE)
    {
        return optional($this->getFirstMedia(self::MOBILE_BANNER))
                ->getUrl('mobile_banner') ?? $default;
    }

    public function clearBannerImage()
    {
        $this->clearMediaCollection(self::BANNER_IMAGE);
    }

    public function setMobileBanner(UploadedFile $upload)
    {
        $this->clearMobileBanner();
        return $this->addMedia($upload)
            ->usingFileName($upload->hashName())
            ->toMediaCollection(self::MOBILE_BANNER);
    }

    public function clearMobileBanner()
    {
        $this->clearMediaCollection(self::MOBILE_BANNER);
    }

    public function setCardImage(UploadedFile $upload)
    {
        $this->clearCardImage();

        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::CARD_IMAGE);
    }

    public function getCardImage()
    {
        $image = $this->getFirstMedia(self::CARD_IMAGE);

        return [
            'original' => $image ? $image->getUrl() : self::DEFAULT_IMAGE,
            'web'      => $image ? $image->getUrl('web') : self::DEFAULT_IMAGE,
        ];
    }

    public function clearCardImage()
    {
        $this->clearMediaCollection(self::CARD_IMAGE);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('banner')
             ->fit(Manipulations::FIT_CROP, 2000, 1000)
             ->optimize()
             ->performOnCollections(self::BANNER_IMAGE);

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_CROP, 1200, 800)
             ->optimize()
             ->performOnCollections(self::CARD_IMAGE);

        $this->addMediaConversion('mobile_banner')
             ->fit(Manipulations::FIT_CROP, 1000, 1000)
             ->optimize()
             ->performOnCollections(self::MOBILE_BANNER);
    }

    public function cardInfo(): ContentCardInfo
    {
        $image = $this->getFirstMedia(self::CARD_IMAGE);

        return new ContentCardInfo([
            'category'   => [
                'en' => Lang::get('content-cards.event', [], 'en'),
                'zh' => Lang::get('content-cards.event', [], 'zh'),
            ],
            'title'      => $this->name,
            'link'       => "/events/{$this->slug}",
            'image_path' => $image ? Storage::disk('media')->path(Str::after($image->getUrl(), "/media/")) : '',
        ]);
    }

    public function safeDelete()
    {
        $this->activities()->delete();
        $this->delete();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'canonical_url' => "/events/{$this->slug}",
            'location' => $this->location,
            'venue_name' => $this->venue_name,
            'overview' => $this->overview->toArray(),
            'intro' => $this->intro,
            'result' => [
                'languages' => ['en', 'zh'],
                'title' => [
                    'en' => $this->name['en'] ?? '',
                    'zh' => $this->name['zh'] ?? ''
                ],
                'description' => [
                    'en' => $this->intro['en'] ?? '',
                    'zh' => $this->intro['zh'] ?? ''
                ]
            ]
        ];
    }
}
