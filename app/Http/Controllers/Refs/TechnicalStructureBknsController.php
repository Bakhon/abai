<?php

namespace App\Http\Controllers\Refs;

use App\Models\Refs\TechnicalStructureBkns;


class TechnicalStructureBknsController extends TechnicalStructureController
{
    protected $model = "App\Models\Refs\TechnicalStructureBkns";

    protected $controller_name = 'bkns';
    protected $index_route = "tech_struct_bkns.index";
}
