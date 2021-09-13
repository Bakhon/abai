<?php

namespace App\Http\Controllers\Refs;


class TechnicalStructureBknsController extends TechnicalStructureController
{
    protected $model = "App\Models\Refs\TechnicalStructureBkns";

    protected $controller_name = 'bkns';
    protected $indexRoute = "tech_struct_bkns.index";
}
