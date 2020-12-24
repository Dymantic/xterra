<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show()
    {
        $query = request('q', '');

        return view('front.search.page', ['query' => $query]);
    }
}
