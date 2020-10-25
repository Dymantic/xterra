<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentCardRequest;
use App\Media\ContentCard;
use Illuminate\Http\Request;

class ContentCardController extends Controller
{

    public function index()
    {
        return ContentCard::all()->map->toArray();
    }

    public function store(ContentCardRequest $request)
    {
        ContentCard::new($request->contentCardInfo());
    }

    public function update(ContentCardRequest $request, ContentCard $card)
    {
        $card->update($request->contentCardInfo()->toArray());
    }

    public function delete(ContentCard $card)
    {
        $card->delete();
    }
}
