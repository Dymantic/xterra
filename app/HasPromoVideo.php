<?php


namespace App;


use App\Media\PromoVideo;

trait HasPromoVideo
{
    public function promoVideo()
    {
        return $this->belongsTo(PromoVideo::class);
    }

    public function setPromoVideo($video_id, Translation $title)
    {
        $this->clearPromoVideo();

        $promo = PromoVideo::new($video_id, $title);
        $this->promo_video_id = $promo->id;
        $this->save();

        return $promo;
    }

    public function clearPromoVideo()
    {
        if ($this->promo_video_id) {
            $this->promoVideo->safeDelete();
        }
        $this->promo_video_id = null;
        $this->save();
    }
}
