<?php

namespace App\Media;

use Illuminate\Database\Eloquent\Model;

class BannerVideo extends Model
{

    const DISK_NAME = 'admin_uploads';

    protected $fillable = ['disk', 'filename'];

    public function bannerable()
    {
        return $this->morphTo();
    }
}
