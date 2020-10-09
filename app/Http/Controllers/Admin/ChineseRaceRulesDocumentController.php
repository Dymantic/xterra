<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Occasions\Activity;
use Illuminate\Http\Request;

class ChineseRaceRulesDocumentController extends Controller
{
    public function store(Activity $race)
    {
        request()->validate([
            'rules_doc' => ['file']
        ]);

        $race->setChineseRulesAndInfoDoc(request('rules_doc'));
    }

    public function destroy(Activity $race)
    {
        $race->clearChineseRulesAndInfoDoc();
    }
}
