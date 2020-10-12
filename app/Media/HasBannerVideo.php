<?php


namespace App\Media;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasBannerVideo
{
    public function bannerVideo()
    {
        return $this->morphOne(BannerVideo::class, 'bannerable');
    }

    public function setBannerVideo(UploadedFile $upload)
    {
        $this->clearBannerVideo();

        $path = $upload->store('banner_videos', BannerVideo::DISK_NAME);

        return $this->bannerVideo()->create([
            'disk'     => BannerVideo::DISK_NAME,
            'filename' => $path,
        ]);
    }

    public function clearBannerVideo()
    {
        $video = $this->bannerVideo;
        if (!$video) {
            return;
        }
        if (Storage::disk(BannerVideo::DISK_NAME)->exists($video->filename)) {
            Storage::disk(BannerVideo::DISK_NAME)->delete($video->filename);
        }
        $this->bannerVideo()->delete();
    }

    public function bannerVideoUrl()
    {
        $video = $this->bannerVideo;

        return $video ? sprintf("/%s/%s", $video->disk, $video->filename) : "";
    }
}
