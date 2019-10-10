<?php

namespace App\Slider;

use App\Blog\Article;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $fillable = ['position', 'article_id'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
