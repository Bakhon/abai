<?php

namespace App\Http\Controllers\VisCenter\Kpd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\Kpd\KpdTreeCatalog;
use App\Models\VisCenter\Kpd\KpdCorporateManager;
use Carbon\Carbon;

class KpdTreeController extends Controller
{
    public function kpdTree()
    {
        return view('visualcenter.kpd_tree');
    }

    public function getCorporateManager()
    {
        return KpdCorporateManager::query()
           ->where('year',Carbon::now()->year)
           ->first();
    }

    public function storeCorporateManager(Request $request)
    {
        if (!is_string($request->avatar)) {
            $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('/img/kpd-tree/corporate-manager'), $imageName);
        } else {
            $imageName = $request->avatar;
        }

        KpdCorporateManager::updateOrCreate(
            [
                'year' => Carbon::now()->year
            ],
            [
                'name' => $request->name,
                'title' => $request->title,
                'avatar' => $imageName,
                'year' => Carbon::now()->year
            ]
        );
    }

    public function getAll()
    {
        return KpdTreeCatalog::query()
            ->get()
            ->toArray();
    }

    public function storeKpd(Request $request)
    {
        KpdTreeCatalog::create($request->request->all());
    }
}
