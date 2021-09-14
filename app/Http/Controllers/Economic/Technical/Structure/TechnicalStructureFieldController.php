<?php

namespace App\Http\Controllers\Economic\Technical\Structure;

use App\Http\Requests\Economic\Technical\Structure\TechnicalStructureStoreFieldRequest;
use App\Models\Refs\TechnicalStructureCompany;
use App\Models\Refs\TechnicalStructureField;
use Illuminate\Contracts\View\View;

class TechnicalStructureFieldController extends TechnicalStructureController
{
    protected $viewName = 'field';

    protected $model = TechnicalStructureField::class;

    protected $storeRequest = TechnicalStructureStoreFieldRequest::class;

    public function create(): View
    {
        $companies = TechnicalStructureCompany::get();

        return view('economic.technical.field.create', compact('companies'));
    }

    public function edit(int $id): View
    {
        $model = $this->model::findOrFail($id);

        $companies = TechnicalStructureCompany::get();

        return view(
            'economic.technical.field.edit',
            compact('model', 'companies')
        );
    }
}
