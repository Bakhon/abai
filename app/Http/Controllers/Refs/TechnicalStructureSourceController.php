<?php

namespace App\Http\Controllers\Refs;

use App\Models\Refs\TechnicalStructureSource;


class TechnicalStructureSourceController extends TechnicalStructureController
{
    protected $model = "App\Models\Refs\TechnicalStructureSource";

    protected $controller_name = 'source';
    protected $index_route = "tech_struct_source.index";

    public function sourceDataJson(): array
    {
        return [
            'sources' => TechnicalStructureSource::all()
        ];
    }
}
