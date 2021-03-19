<?php

namespace App\Http\Controllers\Refs;

use App\Models\Refs\TechnicalStructureCompany;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TechnicalStructureFieldController extends TechnicalStructureController
{
    protected $model = "App\Models\Refs\TechnicalStructureField";

    protected $controller_name = 'field';
    protected $index_route = "tech_struct_field.index";

    public function create(): View
    {
        $company = TechnicalStructureCompany::get();
        return view('technical_forecast.field.create',compact('company'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'company_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $this->model::create($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $technicalForecast = $this->model::find($id);
        $company = TechnicalStructureCompany::get();
        return view('technical_forecast.field.edit',compact('technicalForecast', 'company'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $technicalForecast=$this->model::find($id);
        $request->validate([
            'name' => 'required',
            'company_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $technicalForecast->update($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.updated'));
    }

}
