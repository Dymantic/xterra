<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Media\ContentCard;
use Illuminate\Http\Request;

class ContentCardsOrderController extends Controller
{
    public function store()
    {
        request()->validate([
            'card_ids'   => ['required', 'array'],
            'card_ids.*' => ['exists:content_cards,id']
        ]);

        ContentCard::setOrder(request('card_ids'));
    }
}
