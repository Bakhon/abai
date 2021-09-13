<?php

namespace App\Http\Controllers\Economic\Technical\Structure;

use App\Http\Requests\Economic\Technical\Structure\TechnicalStructureStoreCdngRequest;
use App\Models\Refs\TechnicalStructureCdng;
use App\Models\Refs\TechnicalStructureNgdu;
use Illuminate\Contracts\View\View;


class TechnicalStructureCdngController extends TechnicalStructureController
{
    protected $viewName = 'cdng';

    protected $model = TechnicalStructureCdng::class;

    protected $storeRequest = TechnicalStructureStoreCdngRequest::class;

    public function create(): View
    {
        $ngdus = TechnicalStructureNgdu::get();

        return view('economic.technical.cdng.create', compact('ngdus'));
    }

    public function edit(int $id): View
    {
        $model = $this->model::findOrFail($id);

        $ngdus = TechnicalStructureNgdu::get();

        return view(
            'economic.technical.cdng.edit',
            compact('model', 'ngdus')
        );
    }
}
