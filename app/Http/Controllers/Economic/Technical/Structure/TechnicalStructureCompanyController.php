<?php

namespace App\Http\Controllers\Economic\Technical\Structure;

use App\Http\Requests\Economic\Technical\Structure\TechnicalStructureStoreCompanyRequest;
use App\Models\Refs\TechnicalStructureCompany;


class TechnicalStructureCompanyController extends TechnicalStructureController
{
    protected $viewName = 'company';

    protected $model = TechnicalStructureCompany::class;

    protected $storeRequest = TechnicalStructureStoreCompanyRequest::class;
}
