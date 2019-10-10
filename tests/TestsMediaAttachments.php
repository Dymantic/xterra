<?php


namespace Tests;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait TestsMediaAttachments
{
    public function assertDiskHasMediaImage($disk, $image)
    {
        $disk_path = Str::replaceFirst('/media', '', $image->getUrl());
        Storage::disk($disk)->assertExists($disk_path);
    }

    public function assertDiskHasMediaImageConversions($disk, $image, $expected_conversions)
    {
        $expected_conversions->map(function($conversion) use ($image) {
            return Str::replaceFirst('/media', '', $image->getUrl($conversion));
        })->each(function($path) use ($disk) {
            Storage::disk($disk)->assertExists($path);
        });
    }
}