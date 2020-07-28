<?php


namespace App;


use App\Media\EmbeddableVideo;

trait HasEmbeddedVideos
{
    public function embeddableVideos()
    {
        return $this->morphMany(EmbeddableVideo::class, 'videoed');
    }

    public function addYoutubeVideo(string $video_id, Translation $title): EmbeddableVideo
    {
        return $this->embeddableVideos()->create([
            'title'    => $title,
            'video_id' => $video_id,
            'platform' => EmbeddableVideo::YOUTUBE,
        ]);
    }
}
