<?php


namespace App\People;


use Illuminate\Http\UploadedFile;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasProfilePic
{

    public function getProfilePic($default = Profile::DEFAULT_ADMIN)
    {
        $profile_pic = $this->getFirstMedia(Profile::AVATAR);

        return [
            'thumb' => optional($profile_pic)->getUrl('thumb') ?? $default,
            'web' => optional($profile_pic)->getUrl('web') ?? $default,
        ];
    }

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
