<?php

namespace App\Media;

use App\HasEmbeddedVideos;
use App\Translation;
use Illuminate\Database\Eloquent\Model;

class PromoVideo extends Model
{
    use HasEmbeddedVideos;

    public static function new($video_id, Translation $title): self
    {
        $promo = self::create([]);

        $promo->addYouTubeVideo($video_id, $title);

        return $promo;
    }

    public function safeDelete()
    {
        $this->embeddableVideos()->delete();
        $this->delete();
    }

    public function getVideo()
    {
        return $this->embeddableVideos()->first();
    }

    public function getPlatform()
    {
        return optional($this->embeddableVideos()->first())->platform;
    }

    public function getVideoId()
    {
        return optional($this->embeddableVideos()->first())->video_id;
    }
}
