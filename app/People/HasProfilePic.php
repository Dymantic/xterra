<?php


namespace App\People;


use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;

trait HasProfilePic
{
    public function setProfilePic(UploadedFile $upload): Media
    {
        $this->clearProfilePic();
        return $this
            ->addMedia($upload)
            ->usingFileName($upload->hashName())
            ->toMediaCollection(Profile::AVATAR);
    }

    public function clearProfilePic()
    {
        $this->clearMediaCollection(Profile::AVATAR);
    }


}
