<?php

namespace App\Http\Controllers\Refs;

use App\Models\Refs\TechnicalStructureCdng;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class TechnicalStructureGuController extends TechnicalStructureController
{
    protected $model = "App\Models\Refs\TechnicalStructureGu";

    protected $controller_name = 'gu';
    protected $index_route = "tech_struct_gu.index";

    public function create(): View
    {
        $cdng = TechnicalStructureCdng::get();
        return view('technical_forecast.gu.create',compact('cdng'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'cdng_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $this->model::create($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $technicalForecast = $this->model::find($id);
        $cdng = TechnicalStructureCdng::get();
        return view('technical_forecast.gu.edit',compact('technicalForecast', 'cdng'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $technicalForecast=$this->model::find($id);
        $request->validate([
            'name' => 'required',
            'cdng_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $technicalForecast->update($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.updated'));
    }
}
