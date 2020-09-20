<?php

namespace App\Campaigns;

use App\Blog\Article;
use App\JsonToBladeParser;
use App\Occasions\Event;
use App\Shop\Promotion;
use App\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Campaign extends Model implements HasMedia
{
    use HasMediaTrait;

    const TITLE_IMAGE = 'title-image';
    const NARRATIVE_IMAGES = 'narrative-image';
    const DEFAULT_IMAGE = '/images/default_image.jpg';

    protected $fillable = [
        'title',
        'description',
        'intro',
    ];

    protected $casts = [
        'title' => Translation::class,
        'description' => Translation::class,
        'intro' => Translation::class,
        'narrative' => Translation::class,
    ];

    public static function new(CampaignInfo $info): self
    {
        return self::create($info->toArray());
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
     *@test
     */
    public function clearTitleImage()
    {
        $this->clearMediaCollection(self::TITLE_IMAGE);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 500, 333)
             ->optimize()
             ->performOnCollections(self::TITLE_IMAGE);

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_CROP, 1200, 800)
             ->optimize()
             ->performOnCollections(self::TITLE_IMAGE, self::NARRATIVE_IMAGES);
    }

    public function presentForAdmin()
    {
        return CampaignPresenter::forAdmin($this);
    }
}
