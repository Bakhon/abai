<?php

namespace App\Http\Controllers\Refs;

use App\Models\Refs\TechnicalStructureNgdu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class TechnicalStructureCdngController extends TechnicalStructureController
{
    protected $model = "App\Models\Refs\TechnicalStructureCdng";

    protected $controller_name = 'cdng';
    protected $indexRoute = "tech_struct_cdng.index";

    public function create(): View
    {
        $ngdu = TechnicalStructureNgdu::get();
        return view('technical_forecast.cdng.create', compact('ngdu'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'ngdu_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $this->model::create($dataArray);

        return redirect()->route($this->indexRoute)->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $technicalForecast = $this->model::find($id);
        $ngdu = TechnicalStructureNgdu::get();
        return view('technical_forecast.cdng.edit', compact('technicalForecast', 'ngdu'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $technicalForecast=$this->model::find($id);
        $request->validate([
            'name' => 'required',
            'ngdu_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $technicalForecast->update($dataArray);

        return redirect()->route($this->indexRoute)->with('success',__('app.updated'));
    }

}
