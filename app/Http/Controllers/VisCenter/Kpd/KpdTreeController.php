<?php

namespace App\Http\Controllers\VisCenter\Kpd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\Kpd\KpdTreeCatalog;
use Carbon\Carbon;

class KpdTreeController extends Controller
{
    public function kpdTree()
    {
        return view('visualcenter.kpd_tree');
    }

    public function getAll()
    {
        return KpdTreeCatalog::query()
            ->get()
            ->toArray();
    }

    public function storeKpd(Request $request)
    {
        var_dump($request->request->all());
        KpdTreeCatalog::create($request->request->all());
    }
}
