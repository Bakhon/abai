<?php

namespace App\Http\Controllers\Refs;

use App\Models\Refs\TechnicalStructureCompany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class TechnicalStructureCompanyController extends TechnicalStructureController
{
    protected $model = TechnicalStructureCompany::class;

    protected $controller_name = 'company';
    protected $index_route = "tech_struct_company.index";

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'short_name' => 'nullable|string',
            'tbd_id' => 'nullable|numeric',
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $this->model::create($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.created'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $techRefsCompany=$this->model::find($id);
        $request->validate([
            'name' => 'required',
            'short_name' => 'nullable|string',
            'tbd_id' => 'nullable|numeric',
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $techRefsCompany->update($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.updated'));
    }

}
