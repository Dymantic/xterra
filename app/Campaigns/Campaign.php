<?php

namespace App\Campaigns;

use App\Blog\Article;
use App\HasEmbeddedVideos;
use App\HasPromoVideo;
use App\JsonToBladeParser;
use App\Media\BannerVideo;
use App\Media\HasBannerVideo;
use App\Media\PromoVideo;
use App\Occasions\Event;
use App\Shop\Promotion;
use App\Translation;
use App\UniqueKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Campaign extends Model implements HasMedia
{
    use InteractsWithMedia, HasPromoVideo, HasBannerVideo;

    const TITLE_IMAGE = 'title-image';
    const NARRATIVE_IMAGES = 'narrative-image';
    const BANNER_IMAGE = 'banner_image';
    const DEFAULT_IMAGE = '/images/default_image.svg';

    protected $fillable = [
        'title',
        'description',
        'intro',
        'slug',
    ];

    protected $casts = [
        'title'       => Translation::class,
        'description' => Translation::class,
        'intro'       => Translation::class,
        'narrative'   => Translation::class,
        'is_public'   => 'boolean',
    ];

    public static function new(CampaignInfo $info): self
    {

        return self::create(
            array_merge($info->toArray(), ['slug' => UniqueKey::for('campaigns:slug')])
        );
    }

    public function scopeLive($query)
    {
        return $query->where('is_public', true);
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

    public function updateNarrative($narrative, $lang)
    {
        $this->narrative->translations[$lang] = $narrative;
        $this->save();
    }

    public function narrativeHtml($lang)
    {
        $parser = new JsonToBladeParser("editorjs.campaigns");

        return $parser->html($this->narrative->translations[$lang] ?? '');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function setEvent(Event $event)
    {
        $this->event_id = $event->id;
        $this->save();
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function setPromotion(Promotion $promotion)
    {
        $this->promotion_id = $promotion->id;
        $this->save();
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function attachArticle(Article $article)
    {
        $this->articles()->attach($article->id);
    }

    public function removeArticle(Article $article)
    {
        $this->articles()->detach($article->id);
    }

    public function titleImage()
    {
        return $this->getFirstMedia(self::TITLE_IMAGE);
    }

    public function setTitleImage(UploadedFile $upload): Media
    {
        $this->clearTitleImage();

        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->preservingOriginal()
                    ->toMediaCollection(self::TITLE_IMAGE);
    }

    public function setNarrativeImage(UploadedFile $upload): Media
    {
        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::NARRATIVE_IMAGES);
    }

    /**
     * @test
     */
    public function clearTitleImage()
    {
        $this->clearMediaCollection(self::TITLE_IMAGE);
    }

    public function setBannerImage(UploadedFile $upload)
    {
        $this->clearBannerImage();

        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::BANNER_IMAGE);
    }

    public function clearBannerImage()
    {
        $this->clearMediaCollection(self::BANNER_IMAGE);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 500, 333)
             ->optimize()
             ->performOnCollections(self::TITLE_IMAGE);

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_CROP, 1200, 800)
             ->optimize()
             ->performOnCollections(self::TITLE_IMAGE, self::NARRATIVE_IMAGES);

        $this->addMediaConversion('full')
             ->fit(Manipulations::FIT_CROP, 2000, 1125)
             ->optimize()
             ->performOnCollections(self::BANNER_IMAGE,);

        $this->addMediaConversion('small')
             ->fit(Manipulations::FIT_CROP, 1000, 1000)
             ->optimize()
             ->performOnCollections(self::BANNER_IMAGE,);
    }

    public function presentForAdmin()
    {
        return CampaignPresenter::forAdmin($this);
    }


}
