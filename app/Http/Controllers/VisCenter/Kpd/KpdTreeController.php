<?php

namespace App\Http\Controllers\VisCenter\Kpd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\Kpd\KpdTreeCatalog;
use App\Models\VisCenter\Kpd\KpdCorporateManager;
use App\Models\VisCenter\Kpd\KpdManagers;
use App\Models\VisCenter\Kpd\KpdElements;
use App\Models\VisCenter\Kpd\KpdFact;
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
            $request->avatar->move(public_path('/img/kpd-tree/managers'), $imageName);
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

    public function getManagers(Request $request)
    {
        return KpdManagers::query()
           ->where('year',Carbon::now()->year)
           ->where('type',$request->type)
           ->get();
    }

    public function storeManager(Request $request)
    {
        if (!is_string($request->avatar)) {
            $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('/img/kpd-tree/managers'), $imageName);
        } else {
            $imageName = $request->avatar;
        }
        $managerId = $request->id;
        if ($managerId === "undefined") {
            $managerId = null;
        }

        KpdManagers::updateOrCreate(
            [
                'id' => $managerId,
            ],
            [
                'name' => $request->name,
                'title' => $request->title,
                'avatar' => $imageName,
                'type' => $request->type,
                'year' => Carbon::now()->year
            ]
        );
    }

    public function getAll()
    {
        return KpdTreeCatalog::query()
            ->select(['id','name','description','unit','formula','responsible','functions','type','result','calculation_document','description_document'])
            ->with('kpdElements:id,kpd_id,name,transcript,unit,source,responsible')
            ->get();
    }

    public function storeKpd(Request $request)
    {
        $elements = json_decode($request->elements,true);
        $allParams = $request->request->all();
        $parentId = null;
        if (!is_null($request->description_document) && !is_string($request->description_document)) {
            $description_document = time().'.'.$request->description_document->getClientOriginalExtension();
            $request->description_document->move(public_path('/documents/kpd-tree'), $description_document);
        } else {
            $description_document = $request->description_document;
        }
        if (!is_null($request->calculation_document) && !is_string($request->calculation_document)) {
            $calculation_document = time().'.'.$request->calculation_document->getClientOriginalExtension();
            $request->calculation_document->move(public_path('/documents/kpd-tree'), $calculation_document);
        } else {
            $calculation_document = $request->calculation_document;
        }

        if (isset($allParams['id'])) {
            $parentId = $allParams['id'];
            unset($allParams['id']);
        }
        unset($allParams['elements']);
        $allParams['description_document'] = $description_document;
        $allParams['calculation_document'] = $calculation_document;

        $kpd = KpdTreeCatalog::updateOrCreate(
            [
                'id' => $parentId,
            ],
            $allParams
        );

        if (is_null($elements)) {
            return;
        }

        foreach ($elements as $element) {
            if (isset($element['id'])) {
                $elementId = $element['id'];
                unset($element['id']);
                unset($element['kpd_id']);
                KpdElements::find($elementId)->update($element);
            } else {
                $kpdElements = new KpdElements;
                $kpdElements->kpdCatalog()->associate($kpd);
                foreach($element as $key => $value) {
                    $kpdElements->$key = $element[$key];
                }
                $el = $kpdElements->save();
            }
        }
    }

    public function deleteKpd(Request $request)
    {
        KpdTreeCatalog::find($request->id)->delete();
    }

    public function getKpdByManager(Request $request)
    {
        return KpdTreeCatalog::query()
            ->where('type',$request->input('type'))
            ->with('kpdFact')
            ->get();
    }

    public function storeUpdatedKpd(Request $request)
    {
        $planParams = array ('step','target','maximum');
        foreach($request->request->all() as $kpd) {
            $kpdRecord = KpdTreeCatalog::query()
                ->where('id',$kpd['id'])
                ->first();
            $isUpdateRequired = false;
            foreach ($planParams as $param) {
                if (is_null($kpdRecord->$param)) {
                    $isUpdateRequired = true;
                    $kpdRecord->$param = $kpd[$param];
                }
            }
            if ($isUpdateRequired) {
                $kpdRecord->save();
            }
            $this->storeKpdFact($kpd['kpd_fact'],$kpdRecord);
        }
    }

    private function storeKpdFact($factByDates,$kpdRecord)
    {
        foreach($factByDates as $fact) {
            if (is_null($fact['id'])) {
                $kpdFact = new KpdFact;
                $kpdFact->kpdCatalog()->associate($kpdRecord);
                $kpdFact->date = Carbon::parse($fact['date']);
                $kpdFact->fact = $fact['fact'];
                $kpdFact->save();
            }
        }
    }
}
