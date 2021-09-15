<?php

namespace App\Http\Controllers\Economic\Technical\Structure;

use App\Models\Refs\TechnicalStructureSource;


class TechnicalStructureSourceController extends TechnicalStructureController
{
    protected $viewName = 'source';

    protected $model = TechnicalStructureSource::class;
}
