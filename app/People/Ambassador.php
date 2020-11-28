<?php

namespace App\People;

use App\HasEmbeddedVideos;
use App\Translation;
use App\UniqueKey;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Ambassador extends Model implements HasMedia
{
    use IsSociable, HasEmbeddedVideos, InteractsWithMedia, HasProfilePic, AttendsEvents, PresentsAsPerson;

    protected $fillable = [
        'name',
        'slug',
        'about',
        'achievements',
        'collaboration',
        'philosophy',
    ];

    protected $casts = [
        'name'          => Translation::class,
        'about'         => Translation::class,
        'achievements'  => Translation::class,
        'collaboration' => Translation::class,
        'philosophy'    => Translation::class,
        'is_public'     => 'boolean',
    ];

    public static function new(AmbassadorInfo $info): Ambassador
    {
        $ambassador = self::create(array_merge($info->toArray(), ['slug' => UniqueKey::for("ambassadors:slug", 4)]));
        $ambassador->setSocialLinks($info->social_links);

        return $ambassador;
    }

    public function updateInfo(AmbassadorInfo $info)
    {
        $this->update($info->toArray());
        $this->setSocialLinks($info->social_links);
    }

    public function fullDelete()
    {
        $this->socialLinks()->delete();
        $this->embeddableVideos()->delete();
        $this->delete();
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

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 600, 400)
             ->optimize()
             ->performOnCollections(Profile::AVATAR);

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_CROP, 900, 600)
             ->optimize()
             ->performOnCollections(Profile::AVATAR);
    }

    public function presentForAdmin()
    {
        return AmbassadorPresenter::forAdmin($this);
    }
}
