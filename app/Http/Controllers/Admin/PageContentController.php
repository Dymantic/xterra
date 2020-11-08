<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageContentController extends Controller
{
    public function update(Page $page)
    {
        request()->validate([
            'content' => ['required'],
            'lang' => ['required', Rule::in(['en', 'zh'])]
        ]);

        $page->setContent(request('content'), request('lang'));
    }
}
