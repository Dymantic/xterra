<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AmbassadorRequest;
use App\People\Ambassador;
use Illuminate\Http\Request;

class AmbassadorsController extends Controller
{

    public function index()
    {
        return Ambassador::latest()->get()->map->presentForAdmin();
    }

    public function store(AmbassadorRequest $request)
    {
        return Ambassador::new($request->ambassadorInfo());
    }

    public function update(Ambassador $ambassador, AmbassadorRequest $request)
    {
        $ambassador->updateInfo($request->ambassadorInfo());
    }

    public function delete(Ambassador $ambassador)
    {
        $ambassador->fullDelete();
    }
}
