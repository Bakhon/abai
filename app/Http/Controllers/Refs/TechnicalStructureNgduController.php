<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\TechnicalStructureField;
use App\Models\Refs\TechnicalStructureNgdu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TechnicalStructureNgduController extends TechnicalStructureController
{
    protected $model = "App\Models\Refs\TechnicalStructureNgdu";

    protected $controller_name = 'ngdu';
    protected $index_route = "tech_struct_ngdu.index";

    public function create(): View
    {
        $field = TechnicalStructureField::get();
        return view('technical_forecast.ngdu.create',compact('field'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'field_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $this->model::create($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $technicalForecast = $this->model::find($id);
        $field = TechnicalStructureField::get();
        return view('technical_forecast.ngdu.edit',compact('technicalForecast', 'field'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $technicalForecast=$this->model::find($id);
        $request->validate([
            'name' => 'required',
            'field_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $technicalForecast->update($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.updated'));
    }

}
