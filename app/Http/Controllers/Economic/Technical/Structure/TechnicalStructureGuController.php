<?php

namespace App\Http\Controllers\Economic\Technical\Structure;

use App\Http\Requests\Economic\Technical\Structure\TechnicalStructureStoreGuRequest;
use App\Models\Refs\TechnicalStructureCdng;
use App\Models\Refs\TechnicalStructureGu;
use Illuminate\Contracts\View\View;


class TechnicalStructureGuController extends TechnicalStructureController
{
    protected $viewName = 'gu';

    protected $model = TechnicalStructureGu::class;

    protected $storeRequest = TechnicalStructureStoreGuRequest::class;

    public function create(): View
    {
        $cdng = TechnicalStructureCdng::get();

        return view('economic.technical.gu.create', compact('cdng'));
    }

    public function edit(int $id): View
    {
        $model = $this->model::findOrFail($id);

        $cdng = TechnicalStructureCdng::get();

        return view(
            'economic.technical.gu.edit',
            compact('model', 'cdng')
        );
    }
}
