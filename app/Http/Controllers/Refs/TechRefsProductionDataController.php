<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\TechRefsProductionData;
use App\Models\Refs\TechRefsGu;
use App\Models\Refs\TechRefsSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'source_id' => 'required',
            'gu_id' => 'required',
            'well_id' => 'required',
            'date' => 'nullable|date',
            'oil' => 'nullable|numeric',
            'liquid' => 'nullable|numeric',
            'days_worked' => 'nullable|numeric',
            'prs' => 'nullable|numeric',
        ]);

        $dataArray = $request->all();
        $dataArray['author_id'] = auth()->user()->id;
        TechRefsProductionData::create($dataArray);

        return redirect()->route('techrefsproductiondata.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified reproductionData.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id): Response
    {
    }

    public function edit(int $id): View
    {
        $techRefsProductionData = TechRefsProductionData::find($id);
        $gu = TechRefsGu::get();
        $source = TechRefsSource::get();
        return view('tech_refs.productionData.edit',
            compact('source', 'techRefsProductionData', 'gu'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $techRefsProductionData=TechRefsProductionData::find($id);
        $request->validate([
            'source_id' => 'required',
            'gu_id' => 'required',
            'well_id' => 'required',
            'date' => 'nullable|date',
            'oil' => 'nullable|numeric',
            'liquid' => 'nullable|numeric',
            'days_worked' => 'nullable|numeric',
            'prs' => 'nullable|numeric',
        ]);

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
        //
    }

}
