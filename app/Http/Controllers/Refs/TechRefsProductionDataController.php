<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Refs\TechProductionDataRequest;
use App\Models\Refs\TechRefsProductionData;
use App\Models\Refs\TechRefsGu;
use App\Models\Refs\TechRefsSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class TechRefsProductionDataController extends Controller
{

    public function index(): View
    {
        $techRefsProductionData = TechRefsProductionData::latest()->paginate(5);

        return view('tech_refs.productionData.index',compact('techRefsProductionData'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        $source = TechRefsSource::get();
        $gu = TechRefsGu::get();
        return view('tech_refs.productionData.create', compact('source', 'gu'));
    }

    public function store(TechProductionDataRequest $request): RedirectResponse
    {
        $dataArray = $request->all();
        $dataArray['author_id'] = auth()->user()->id;
        TechRefsProductionData::create($dataArray);

        return redirect()->route('techrefsproductiondata.index')->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $techRefsProductionData = TechRefsProductionData::find($id);
        $gu = TechRefsGu::get();
        $source = TechRefsSource::get();
        return view('tech_refs.productionData.edit',
            compact('source', 'techRefsProductionData', 'gu'));
    }

    public function update(TechProductionDataRequest $request, int $id): RedirectResponse
    {
        $techRefsProductionData=TechRefsProductionData::find($id);
        $dataArray = $request->all();
        $dataArray['editor_id'] = auth()->user()->id;
        $techRefsProductionData->update($dataArray);

        return redirect()->route('techrefsproductiondata.index')->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $techRefsProductionData = TechRefsProductionData::find($id);
        $techRefsProductionData->delete();

        return redirect()->route('techrefsproductiondata.index')->with('success',__('app.deleted'));
    }

}
