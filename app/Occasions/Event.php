<?php

namespace App\Occasions;

use App\Media\EmbeddableVideo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasActivities, HasSchedule, HasFees, HasPrizes, HasTravelRoutes, HasAccommodation, HasCourses;

    const TRAVEL_GUIDE_DISK = 'admin_uploads';

    protected $fillable = [
        'name',
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
        'location'      => 'array',
        'venue_name'    => 'array',
        'venue_address' => 'array',
        'overview'      => 'array',
        'is_public'     => 'boolean'
    ];

    protected $dates = ['start', 'end'];

    public static function createWithName($name): Event
    {
        return static::create([
            'name'          => [
                'en' => $name['en'] ?? '',
                'zh' => $name['zh'] ?? '',
            ],
            'slug'          => Str::uuid()->toString(),
            'location'      => ['en' => '', 'zh' => ''],
            'venue_name'    => ['en' => '', 'zh' => ''],
            'venue_address' => ['en' => '', 'zh' => ''],
            'overview'      => ['en' => '', 'zh' => ''],
        ]);
    }

    public function updateGeneralInfo(GeneralEventInfo $info)
    {
        $this->update($info->toArray());
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

    public function setTravelGuide(UploadedFile $file)
    {
        $path = $file->store('travel', self::TRAVEL_GUIDE_DISK);

        $this->travel_guide = $path;
        $this->travel_guide_disk = self::TRAVEL_GUIDE_DISK;
        $this->save();
    }

    public function clearTravelGuide()
    {
        if (Storage::disk($this->travel_guide_disk)->exists($this->travel_guide)) {
            Storage::disk($this->travel_guide_disk)->delete($this->travel_guide);
        }

        $this->travel_guide = null;
        $this->travel_guide_disk = null;
        $this->save();
    }

    public function embeddableVideos()
    {
        return $this->morphMany(EmbeddableVideo::class, 'videoed');
    }

    public function attachYoutubeVideo(string $video_id, array $title): EmbeddableVideo
    {
        return $this->embeddableVideos()->create([
            'platform' => EmbeddableVideo::YOUTUBE,
            'video_id' => $video_id,
            'title' => [
                'en' => $title['en'] ?? '',
                'zh' => $title['zh'] ?? '',
            ],
        ]);
    }
}
