<?php


namespace Tests;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait TestsMediaAttachments
{
    public function assertDiskHasMediaImage($disk, $image)
    {
        $disk_path = Str::after($image->getUrl(), '/media');
        Storage::disk($disk)->assertExists($disk_path);
    }

    public function assertDiskHasMediaImageConversions($disk, $image, $expected_conversions)
    {
        $expected_conversions->map(function($conversion) use ($image) {
            return Str::after($image->getUrl($conversion), '/media');
        })->each(function($path) use ($disk) {
            Storage::disk($disk)->assertExists($path);
        });
    }
}
