<?php

namespace App\Http\Controllers\Admin;

use App\Blog\FlaggedComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RejectedFlagsController extends Controller
{
    public function destroy(FlaggedComment $flagged)
    {
        $flagged->delete();
    }
}
