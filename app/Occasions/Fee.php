<?php

namespace App\Occasions;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'category',
        'fee',
        'position',
    ];

    protected $casts = ['category' => 'array'];

    public function presentForLang($lang)
    {
        return [
            'fee' => $this->fee,
            'category' => $this->category[$lang] ?? '',
        ];
    }
}
