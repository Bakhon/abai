<?php

namespace App\Http\Controllers\Economic\Technical\Structure;

use App\Http\Requests\Economic\Technical\Structure\TechnicalStructureStoreNgduRequest;
use App\Models\Refs\TechnicalStructureField;
use App\Models\Refs\TechnicalStructureNgdu;
use Illuminate\Contracts\View\View;


class TechnicalStructureNgduController extends TechnicalStructureController
{
    protected $viewName = 'ngdu';

    protected $model = TechnicalStructureNgdu::class;

    protected $storeRequest = TechnicalStructureStoreNgduRequest::class;

    public function create(): View
    {
        $fields = TechnicalStructureField::get();

        return view('economic.technical.ngdu.create', compact('fields'));
    }

    public function edit(int $id): View
    {
        $model = $this->model::findOrFail($id);

        $fields = TechnicalStructureField::get();

        return view(
            'economic.technical.ngdu.edit',
            compact('model', 'fields')
        );
    }
}
