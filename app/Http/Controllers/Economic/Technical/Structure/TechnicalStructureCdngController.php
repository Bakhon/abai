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
        $ngdu = TechnicalStructureNgdu::get();

        return view('economic.technical.cdng.create', compact('ngdu'));
    }

    public function edit(int $id): View
    {
        $model = $this->model::findOrFail($id);

        $ngdu = TechnicalStructureNgdu::get();

        return view(
            'economic.technical.cdng.edit',
            compact('model', 'ngdu')
        );
    }
}
