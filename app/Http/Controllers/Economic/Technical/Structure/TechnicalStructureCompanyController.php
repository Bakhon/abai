<?php

namespace App\Http\Controllers\Economic\Technical\Structure;

use App\Http\Controllers\Refs\TechnicalStructureController;
use App\Http\Requests\Economic\Technical\Structure\TechnicalStructureStoreRequest;
use App\Models\Refs\TechnicalStructureCompany;
use Illuminate\Http\RedirectResponse;


class TechnicalStructureCompanyController extends TechnicalStructureController
{
    protected $viewName = 'company';

    protected $model = TechnicalStructureCompany::class;

    public function store(TechnicalStructureStoreRequest $request): RedirectResponse
    {
        return parent::store($request);
    }

    public function update(TechnicalStructureStoreRequest $request, int $id): RedirectResponse
    {
        return parent::update($request, $id);
    }
}
