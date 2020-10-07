<?php

namespace App\Occasions;

use App\HasEmbeddedVideos;
use App\JsonToBladeParser;
use App\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Activity extends Model implements HasMedia
{
    use HasSchedule, HasPrizes, HasFees, HasCourses, HasMediaTrait, HasEmbeddedVideos;

    const RUN = 'run';
    const SWIM = 'swim';
    const CYCLE = 'cycle';
    const DUATHLON = 'duathlon';
    const TRIATHLON = 'triathlon';
    const TRAINING = 'training';
    const SEMINAR = 'seminar';
    const LIFESTYLE = 'lifestyle';
    const NO_CATEGORY = 'other';

    const ACTIVITY_TYPES = [
        self::RUN,
        self::SWIM,
        self::CYCLE,
        self::DUATHLON,
        self::TRIATHLON,
        self::SEMINAR,
        self::LIFESTYLE,
        self::NO_CATEGORY,
        self::TRAINING,
    ];

    const RACE_RULES_DISK = 'admin_uploads';
    const ATHLETE_GUIDE_DISK = 'admin_uploads';
    const CONTENT_IMAGES = 'content_images';
    const BANNER_IMAGE = 'banner_image';
    const CARD_IMAGE = 'card_image';
    const DEFAULT_IMAGE = '/images/default_image.svg';

    protected $fillable = [
        'name',
        'description',
        'venue_address',
        'venue_name',
        'date',
        'map_link',
        'registration_link',
        'distance',
        'category',
        'is_race',
        'prizes',
    ];

    protected $casts = [
        'name'           => 'array',
        'distance'       => 'array',
        'description'    => Translation::class,
        'venue_name'     => 'array',
        'venue_address'  => 'array',
        'schedule_notes' => 'array',
        'prize_notes'    => 'array',
        'fees_notes'     => 'array',
        'race_rules'     => 'array',
        'race_info'      => 'array',
        'is_race'        => 'boolean',
        'prizes'         => Translation::class,
    ];

    public function setScheduleNotes($notes)
    {
        $this->schedule_notes = $notes;
        $this->save();
    }

    public function setPrizeNotes($notes)
    {
        $this->prize_notes = $notes;
        $this->save();
    }

    public function setFeesNotes($notes)
    {
        $this->fees_notes = $notes;
        $this->save();
    }

    public function setRulesAndInfoDoc(UploadedFile $upload)
    {
        $path = $upload->store('race_rules', self::RACE_RULES_DISK);

        $this->race_rules_doc = $path;
        $this->race_rules_disk = self::RACE_RULES_DISK;
        $this->save();
    }

    public function clearRulesAndInfoDoc()
    {
        if (Storage::disk($this->race_rules_disk)->exists($this->race_rules_doc)) {
            Storage::disk($this->race_rules_disk)->delete($this->race_rules_doc);
        }

        $this->race_rules_doc = null;
        $this->race_rules_disk = null;
        $this->save();
    }

    public function rulesAndInfoDoc()
    {
        if (Storage::disk($this->race_rules_disk)->exists($this->race_rules_doc)) {
            return sprintf("/%s/%s", $this->race_rules_disk, $this->race_rules_doc);
        }

        return "";
    }

    public function setAthleteGuide(UploadedFile $upload)
    {
        $path = $upload->store('athlete_guides', self::ATHLETE_GUIDE_DISK);

        $this->athlete_guide = $path;
        $this->athlete_guide_disk = self::ATHLETE_GUIDE_DISK;
        $this->save();
    }

    public function clearAthleteGuide()
    {
        if (Storage::disk($this->athlete_guide_disk)->exists($this->athlete_guide)) {
            Storage::disk($this->athlete_guide_disk)->delete($this->athlete_guide);
        }

        $this->athlete_guide = null;
        $this->athlete_guide_disk = null;
        $this->save();
    }

    public function athletesGuide()
    {
        if (Storage::disk($this->athlete_guide_disk)->exists($this->athlete_guide)) {
            return sprintf("/%s/%s", $this->athlete_guide_disk, $this->athlete_guide);
        }

        return "";
    }

    public function updateDescription($description, $lang)
    {
        $this->description->translations[$lang] = $description;
        $this->save();
    }

    public function descriptionHtml($lang)
    {
        $parser = new JsonToBladeParser('editorjs.races');

        return $parser->html($this->description->translations[$lang]);
    }

    public function updateRules($rules, $lang)
    {
        $this->race_rules = array_merge($this->race_rules ?? ['en' => '', 'zh' => ''], [$lang => $rules]);
        $this->save();
    }

    public function updateInfo($info, $lang)
    {
        $this->race_info = array_merge($this->race_info ?? ['en' => '', 'zh' => ''], [$lang => $info]);
        $this->save();
    }

    public function rulesHtml($lang)
    {
        $parser = new JsonToBladeParser('editorjs.races');

        return $parser->html($this->race_rules[$lang] ?? '');
    }

    public function infoHtml($lang)
    {
        $parser = new JsonToBladeParser('editorjs.races');

        return $parser->html($this->race_info[$lang] ?? '');
    }

    public function addContentImage(UploadedFile $upload): Media
    {
        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::CONTENT_IMAGES);
    }

    public function setBannerImage(UploadedFile $upload): Media
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

    public function setCardImage(UploadedFile $upload): Media
    {
        $this->clearCardImage();

        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::CARD_IMAGE);
    }

    public function clearCardImage()
    {
        $this->clearMediaCollection(self::CARD_IMAGE);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_MAX, 1000, 1800)
             ->optimize()
             ->performOnCollections(self::CONTENT_IMAGES);

        $this->addMediaConversion('card')
             ->fit(Manipulations::FIT_MAX, 900, 600)
             ->optimize()
             ->performOnCollections(self::CARD_IMAGE);

        $this->addMediaConversion('banner')
             ->fit(Manipulations::FIT_CROP, 2000, 1125)
             ->optimize()
             ->performOnCollections(self::BANNER_IMAGE);
    }


    public function toArray()
    {
        $card_image = $this->getFirstMedia(self::CARD_IMAGE);
        $banner_image = $this->getFirstMedia(self::BANNER_IMAGE);

        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'category'            => $this->category,
            'distance'            => $this->distance,
            'description'         => $this->description->toArray(),
            'description_html'    => [
                'en' => $this->descriptionHtml('en'),
                'zh' => $this->descriptionHtml('zh'),
            ],
            'venue_name'          => $this->venue_name ?? ['en' => '', 'zh' => ''],
            'venue_address'       => $this->venue_address ?? ['en' => '', 'zh' => ''],
            'date'                => $this->date,
            'map_link'            => $this->map_link,
            'registration_link'   => $this->registration_link,
            'is_race'             => $this->is_race,
            'schedule'            => Schedule::forEvent($this)->toArray(),
            'prizes'              => $this->prizes->toArray(),
            'prizes_html'         => [
                'en' => $this->prizesHtml('en'),
                'zh' => $this->prizesHtml('zh'),
            ],
            'fees'                => $this->fees->map->toArray()->values()->all(),
            'courses'             => $this->courses->map->toArray()->values()->all(),
            'schedule_notes'      => $this->schedule_notes ?? ['en' => '', 'zh' => ''],
            'prize_notes'         => $this->prize_notes ?? ['en' => '', 'zh' => ''],
            'fees_notes'          => $this->fees_notes ?? ['en' => '', 'zh' => ''],
            'race_rules_document' => $this->rulesAndInfoDoc(),
            'athletes_guide'      => $this->athletesGuide(),
            'race_rules'          => $this->race_rules ?? ['en' => '', 'zh' => ''],
            'race_info'           => $this->race_info ?? ['en' => '', 'zh' => ''],
            'race_rules_html'     => [
                'en' => $this->rulesHtml('en'),
                'zh' => $this->rulesHtml('zh'),
            ],
            'race_info_html'      => [
                'en' => $this->infoHtml('en'),
                'zh' => $this->infoHtml('zh'),
            ],
            'title_image'         => [
                'card'   => $card_image ? $card_image->getUrl('card') : self::DEFAULT_IMAGE,
                'banner' => $banner_image ? $banner_image->getUrl('banner') : self::DEFAULT_IMAGE,
            ],
            'video'               => $this->embeddableVideos()->latest()->first(),
        ];
    }
}
