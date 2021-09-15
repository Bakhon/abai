<?php

namespace App\Http\Controllers\Economic\Technical\Structure;


use App\Models\Refs\TechnicalStructureBkns;

class TechnicalStructureBknsController extends TechnicalStructureController
{
    protected $viewName = 'bkns';

    protected $model = TechnicalStructureBkns::class;
}
