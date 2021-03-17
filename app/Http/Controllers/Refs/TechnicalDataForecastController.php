<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Refs\TechProductionDataRequest;
use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class TechnicalDataForecastController extends Controller
{
    protected $index_route = "tech_data_forecast.index";

    public function index(): View
    {
        $technicalDataForecast = TechnicalDataForecast::latest()->paginate(12);

        return view('technical_forecast.production_data.index',compact('technicalDataForecast'));
    }

    public function create(): View
    {
        $source = TechnicalStructureSource::get();
        $gu = TechnicalStructureGu::get();
        return view('technical_forecast.production_data.create', compact('source', 'gu'));
    }

    public function store(TechProductionDataRequest $request): RedirectResponse
    {
        $dataArray = $request->all();
        $dataArray['author_id'] = auth()->user()->id;
        TechnicalDataForecast::create($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $technicalDataForecast = TechnicalDataForecast::find($id);
        $gu = TechnicalStructureGu::get();
        $source = TechnicalStructureSource::get();
        return view('technical_forecast.production_data.edit',
            compact('source', 'technicalDataForecast', 'gu'));
    }

    public function update(TechProductionDataRequest $request, int $id): RedirectResponse
    {
        $technicalDataForecast=TechnicalDataForecast::find($id);
        $dataArray = $request->all();
        $dataArray['editor_id'] = auth()->user()->id;
        $technicalDataForecast->update($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $technicalDataForecast = TechnicalDataForecast::find($id);
        $technicalDataForecast->delete();

        return redirect()->route($this->index_route)->with('success',__('app.deleted'));
    }

}
