<?php

namespace App\People;

use App\HasEmbeddedVideos;
use App\Media\EmbeddableVideo;
use App\Translation;
use App\UniqueKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Coach extends Model implements HasMedia
{
    use InteractsWithMedia, IsSociable, HasEmbeddedVideos, HasProfilePic, AttendsEvents, PresentsAsPerson;

    protected $fillable = [
        'name',
        'slug',
        'location',
        'certifications',
        'experience',
        'philosophy',
        'email',
        'phone',
        'website',
        'line',
    ];

    protected $casts = [
        'name'           => Translation::class,
        'location'       => Translation::class,
        'certifications' => Translation::class,
        'experience'     => Translation::class,
        'philosophy'     => Translation::class,
        'is_public'      => 'boolean',
    ];

    public static function new(CoachInfo $info): Coach
    {
        $coach = self::create(array_merge($info->toArray(), ['slug' => UniqueKey::for("coaches:slug", 4)]));
        $coach->setSocialLinks($info->social_links);

        return $coach;
    }

    public function updateInfo(CoachInfo $info)
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
        return CoachPresenter::forAdmin($this);
    }


}
