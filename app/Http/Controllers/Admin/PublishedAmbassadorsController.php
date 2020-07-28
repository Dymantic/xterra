<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\People\Ambassador;
use Illuminate\Http\Request;

class PublishedAmbassadorsController extends Controller
{
    public function store()
    {
        Ambassador::findOrFail(request('ambassador_id'))->publish();
    }

    public function destroy(Ambassador $ambassador)
    {
        $ambassador->retract();
    }
}
